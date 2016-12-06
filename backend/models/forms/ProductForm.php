<?php

    namespace backend\models\forms;

    use common\models\BrandModel;
    use common\models\CategoryModel;
    use common\models\ProductCharacteristicItemModel;
    use common\models\ProductInCategoryModel;
    use common\models\ProductModel;
    use common\models\ProductOptionModel;
    use common\models\SeoModel;
    use Exception;
    use Yii;
    use yii\alexposseda\fileManager\FileManager;
    use yii\base\Model;
    use yii\caching\DbDependency;
    use yii\helpers\ArrayHelper;

    /**
     * Class ProductForm
     * @package backend\models\forms
     *
     * @property SeoModel     $seo
     * @property ProductModel $product
     * @property int[]        $categories
     * @property mixed        allCategories
     */
    class ProductForm extends Model{
        public $product;
        public $seo;
        public $categories;
        public $error;

        public $characteristic;
        public $options;

        public function rules(){
            return [
                ['categories', 'required'],
                [['categories', 'characteristic', 'options'], 'safe'],
            ];
        }

        public function attributeLabels(){
            return [
                'categories'     => Yii::t('models', 'Categories'),
                'characteristic' => Yii::t('models/product', 'Characteristic'),
                'options'        => Yii::t('models', 'Options')
            ];
        }

        public function init(){
            $this->categories = ArrayHelper::map($this->product->categories, 'id', 'id');
            foreach($this->categories as $key => $category){
                $this->categories[$key] = ['selected' => 'selected'];
            }
        }

        /**
         * @param array $data
         *
         * @return bool
         */
        public function loadData(array $data){
            if($this->load($data) && $this->product->load($data) && $this->seo->load($data)){
                return true;
            }

            return false;
        }

        /**
         * @return bool
         */
        public function save(){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if($this->seo->canSave()){
                    if(!$this->seo->save()){
                        throw new Exception('error to save seo');
                    }
                    $this->product->seo_id = $this->seo->id;
                }else{
                    $this->product->seo_id = null;
                }

                if(!$this->product->save()){
                    throw new Exception('error to save product');
                }

                //region add selected category
                foreach($this->categories as $category_id){
                    $condition = ['product_id' => $this->product->id, 'category_id' => $category_id];
                    /** @var ProductInCategoryModel $product_in_category */
                    $product_in_category = ProductInCategoryModel::find()
                                                                 ->where($condition)
                                                                 ->one();
                    if(!$product_in_category){
                        $product_in_category = new ProductInCategoryModel($condition);
                    }
                    if(!$product_in_category->save()){
                        throw new Exception('error to save category '.$category_id.' to product');
                    }
                }
                //endregion

                //region remove diff category
                /** @var ProductInCategoryModel[] $diff_categories */
                $diff_categories = $this->product->getProductInCategories()
                                                 ->where(['not in', 'category_id', $this->categories])
                                                 ->all();
                if($diff_categories){
                    foreach($diff_categories as $category_delete){
                        $category_delete->delete();
                    }
                }
                //endregion

                //region Clear Session gallery
                $gallery = $this->product->gallery ? json_decode($this->product->gallery) : [];
                foreach($gallery as $gallery_item){
                    FileManager::getInstance()
                               ->removeFromSession($gallery_item);
                }
                //endregion

                $characteristic = json_decode($this->characteristic);
                foreach($characteristic as $key => $value){
                    $prod_characteristic = new ProductCharacteristicItemModel([
                                                                                  'characteristic_id' => $key,
                                                                                  'product_id'        => $this->product->id,
                                                                                  'value'             => $value
                                                                              ]);
                    if(!$prod_characteristic->save()){
                        throw new Exception('error to save characteristic '.$key.' => '.$value);
                    }
                }

                $options = json_decode($this->options);
                foreach($options as $key => $value){
                    $prod_option = new ProductOptionModel([
                                                              'characteristic_id' => $key,
                                                              'product_id'        => $this->product->id,
                                                              'value'             => $value->value,
                                                              'quantity'          => $value->quantity,
                                                              'delta_price'       => $value->delta_price
                                                          ]);
                    if(!$prod_option->save()){
                        throw new Exception('error to save option '.$key.' => '.$value->value);
                    }
                }

                $transaction->commit();

                return true;
            }catch(Exception $e){
                $this->error = $e->getMessage();
                $transaction->rollBack();

                return false;
            }
        }

        /**
         * возвращает сформированный масив всех категорий
         * @return array
         */
        public function getAllCategories(){
            $dependency = new DbDependency([
                                               'sql' => 'SELECT MAX(updated_at) FROM '.CategoryModel::tableName()
                                           ]);

            $categories = CategoryModel::getDb()
                                       ->cache(function($db){
                                           return CategoryModel::find()
                                                               ->all();
                                       }, 3600, $dependency);

            return ArrayHelper::map($categories, 'id', 'title');
        }

        /**
         * возвращает сформированный масив всех брендов
         * @return array
         */
        public function getAllBrand(){
            $dependency = new DbDependency([
                                               'sql' => 'SELECT MAX(updated_at) FROM '.BrandModel::tableName(),
                                           ]);
            $brands = BrandModel::getDb()
                                ->cache(function($db){
                                    return BrandModel::find()
                                                     ->all();
                                }, 3600, $dependency);

            return ArrayHelper::map($brands, 'id', 'title');
        }

    }