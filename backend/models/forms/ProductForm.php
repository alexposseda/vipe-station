<?php

    namespace backend\models\forms;

    use common\components\logger\LoggerEvent;
    use common\models\BrandModel;
    use common\models\CategoryModel;
    use common\models\ProductCharacteristicItemModel;
    use common\models\ProductCharacteristicModel;
    use common\models\ProductInCategoryModel;
    use common\models\ProductModel;
    use common\models\ProductOptionModel;
    use common\models\RelatedProductModel;
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
     * @property mixed        $allCategories
     * @property array        $allRelatedProducts
     **
     */
    class ProductForm extends Model{
        const EVENT_LOGGER_MESSAGE = 'loggerMessage';

        public $product;
        public $seo;
        public $categories;
        public $error;

        public $characteristics  = [];
        public $related_products = [];

        public function rules(){
            return [
                [
                    'categories',
                    'required'
                ],
                [
                    [
                        'categories',
                        'characteristics',
                        'related_products'
                    ],
                    'safe'
                ],
            ];
        }

        public function attributeLabels(){
            return [
                'categories'      => Yii::t('models', 'Categories'),
                'characteristics' => Yii::t('models/product', 'Characteristic'),
                'options'         => Yii::t('models', 'Options')
            ];
        }

        public function init(){
            $this->categories = ArrayHelper::map($this->product->categories, 'id', 'id');
            foreach($this->categories as $key => $category){
                $this->categories[$key] = ['selected' => 'selected'];
            }

            //            /**
            //             * Получаем все характеристики из категорий в которых находиться продукт
            //             */
            //            $characteristics = [];
            //            foreach($this->product->categories as $category){
            //                $characteristics = ArrayHelper::merge($characteristics, $category->productCharacteristics);
            //            }
            //
            //            /**
            //             * Формируем массив характеристик продукта
            //             */
            //            $this->characteristics = [];
            //            foreach($characteristics as $characteristic){
            //                $condition = ['characteristic_id' => $characteristic->id];
            //                $char_m = ProductCharacteristicItemModel::findOne($condition);
            //                if(!$char_m){
            //                    $char_m = new ProductCharacteristicItemModel($condition);
            //                }
            //                $this->characteristics[] = $char_m;
            //            }
            //
            //            /**
            //             * Формируем массив опций продукта
            //             */
            //            $this->options = [];
            //            foreach($characteristics as $characteristic){
            //                $condition = ['characteristic_id' => $characteristic->id];
            //                $opt_m = ProductOptionModel::findOne($condition);
            //                if(!$opt_m){
            //                    $opt_m = new ProductOptionModel($condition);
            //                }
            //                $this->options[] = $opt_m;
            //            }

            if(!$this->product->isNewRecord){

                //                $characteristicsFromCategories = [];
                //                foreach($this->product->categories as $category){
                //                    if(!empty($category->parent0->productCharacteristics)){
                //                        foreach($category->parent0->productCharacteristics as $productCharacteristic){
                //                            $characteristicsFromCategories[] = new ProductCharacteristicItemModel(['characteristic_id' => $productCharacteristic->id]);
                //                        }
                //                    }
                //                    if(!empty($category->productCharacteristics)){
                //                        foreach($category->productCharacteristics as $productCharacteristic){
                //                            $characteristicsFromCategories[] = new ProductCharacteristicItemModel(['characteristic_id' => $productCharacteristic->id]);
                //                        }
                //                    }
                //                }
                //
                //                foreach( as $productCharacteristicItem){
                //
                //                }
                $this->characteristics = $this->product->productCharacteristicItems;
            }
        }

        /**
         * Загружаем из POST данные в форму, продукт и сео
         *
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
         * Сохраняем в транзакции сео, продукт, категорию продукта, характеристики и опции
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
                    $condition = [
                        'product_id'  => $this->product->id,
                        'category_id' => $category_id
                    ];
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

                foreach($this->related_products as $rel_prod_id){
                    $condition = [
                        'base_product'    => $this->product->id,
                        'related_product' => $rel_prod_id
                    ];
                    $relatedProduct = RelatedProductModel::find()
                                                         ->where($condition)
                                                         ->one();
                    if(!$relatedProduct){
                        $relatedProduct = new RelatedProductModel($condition);
                    }
                    if(!$relatedProduct->save()){
                        throw new Exception('error to save product '.$rel_prod_id.' to related product');
                    }
                }

                //region remove diff category
                /** @var ProductInCategoryModel[] $diff_categories */
                $diff_categories = $this->product->getProductInCategories()
                                                 ->where([
                                                             'not in',
                                                             'category_id',
                                                             $this->categories
                                                         ])
                                                 ->all();
                if($diff_categories){
                    foreach($diff_categories as $category_delete){
                        $category_delete->delete();
                    }
                }
                //endregion

                //region Characteristics
                $characteristics = [];
                $setChar = [];
                $postCharacteristic = Yii::$app->request->post('ProductCharacteristicItemModel');
                $postCharacteristic = $postCharacteristic ? $postCharacteristic : [];
                foreach($postCharacteristic as $id => $item){
                    $condition = [
                        'characteristic_id' => $id,
                        'product_id'        => $this->product->id
                    ];
                    if(ProductCharacteristicItemModel::find()
                                                     ->where($condition)
                                                     ->exists()
                    ){
                        $characteristics[$id] = ProductCharacteristicItemModel::findOne($condition);
                    }else{
                        $characteristics[$id] = new ProductCharacteristicItemModel($condition);
                    }
                    $setChar[] = $id;
                }
                if(Model::loadMultiple($characteristics, Yii::$app->request->post()) && Model::validateMultiple($characteristics)){
                    foreach($characteristics as $characteristic){
                        if(!$characteristic->save(false)){
                            throw new Exception('error save characteristic');
                        }
                    }
                }
                $charTmp = $this->product->getProductCharacteristicItems()
                                         ->where([
                                                     'not in',
                                                     'characteristic_id',
                                                     $setChar
                                                 ])
                                         ->all();
                foreach($charTmp as $item){
                    $item->delete();
                }
                //endregion

                //region Options
                //                $options = [];
                //                $setOp = [];
                //                $postOptions = Yii::$app->request->post('ProductOptionModel');
                //                $postOptions = $postOptions ? $postOptions : [];
                //
                //                foreach($postOptions as $id => $item){
                //                    $condition = [
                //                        'characteristic_id' => $id,
                //                        'product_id'        => $this->product->id
                //                    ];
                //                    if(ProductOptionModel::find()
                //                                         ->where($condition)
                //                                         ->exists()
                //                    ){
                //                        $options[$id] = ProductOptionModel::findOne($condition);
                //                    }else{
                //                        $options[$id] = new ProductOptionModel($condition);
                //                    }
                //                    $setOp[] = $id;
                //                }
                //                if(Model::loadMultiple($options, Yii::$app->request->post()) && Model::validateMultiple($options)){
                //                    foreach($options as $option){
                //                        if(!$option->save(false)){
                //                            throw new Exception('error save characteristic');
                //                        }
                //                    }
                //                }
                //                /**
                //                 * Выбираем все опции которые есть у продукта и не пришли из формы и удаляем их
                //                 */
                //                $optTmp = $this->product->getProductOptions()
                //                                        ->where([
                //                                                    'not in',
                //                                                    'characteristic_id',
                //                                                    $setOp
                //                                                ])
                //                                        ->all();
                //                foreach($optTmp as $item){
                //                    $item->delete();
                //                }
                //endregion

                $transaction->commit();

                //region Clear Session gallery
                $gallery = $this->product->gallery ? json_decode($this->product->gallery) : [];
                foreach($gallery as $gallery_item){
                    FileManager::getInstance()
                               ->removeFromSession($gallery_item);
                }

                //endregion

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
                                       }, 0, $dependency);

            return ArrayHelper::map($categories, 'id', 'title');
        }

        /**
         * возвращает сформированный масив всех категорий
         * @return array
         */
        public function getAllRelatedProducts(){
            $models = RelatedProductModel::find()
                                         ->where(['base_product' => $this->product->id])
                                         ->orWhere(['related_product' => $this->product->id])
                                         ->all();
            $list = [];
            if($models){
                foreach($models as $model){
                    if($model->baseProduct->id != $this->product->id){
                        $list[$model->baseProduct->id] = ['selected' => 'selected'];
                    }
                    if($model->relatedProduct->id != $this->product->id){
                        $list[$model->relatedProduct->id] = ['selected' => 'selected'];
                    }
                }
            }

            return $list;
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
                                }, 0, $dependency);

            return ArrayHelper::map($brands, 'id', 'title');
        }

    }