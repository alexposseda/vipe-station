<?php

    namespace backend\models\forms;

    use Yii;
    use yii\base\Model;
    use yii\db\Exception;
    use common\models\CategoryModel;
    use common\models\SeoModel;
    use common\models\ProductCharacteristicModel;
    use yii\helpers\ArrayHelper;

    /**
     * Class CategoryForm
     * @package backend\models\forms
     *
     * @property SeoModel                      $seo
     * @property CategoryModel                 $category
     * @property ProductCharacteristicModel [] $characteristics
     * @property ProductCharacteristicModel [] $parentCharacteristics
     */
    class CategoryForm extends Model{

        public $category;
        public $seo;
        public $characteristics = [];

        public function save(){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $this->saveSeo();
                $this->saveCategory();
                $this->saveCharacteristics();

                $transaction->commit();

                return true;
            }catch(Exception $e){
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());

                return false;
            }
        }

        /**
         * Сохраняем сео
         *
         * @throws Exception
         */
        protected function saveSeo(){
            if($this->seo->load(Yii::$app->request->post()) && $this->seo->validate()){
                if($this->seo->canSave()){
                    $this->seo->save(false);
                    $this->category->seo_id = $this->seo->id;
                }else if(!$this->seo->isNewRecord){
                    $this->seo->delete();
                    $this->category->seo_id = null;
                }else{
                    if(!$this->seo->isNewRecord){
                        if(!$this->seo->delete()){
                            throw new Exception('error to delete seo');
                        }
                    }
                    $this->category->seo_id = null;
                }
            }else{
                $this->addErrors($this->seo->getErrors());
                throw new Exception(Yii::t('system/error', 'Sorry, I can not save the seo data'));
            }
        }

        /**
         * Сохраняем категорию
         *
         * @throws Exception
         */
        protected function saveCategory(){
            if($this->category->load(Yii::$app->request->post()) && $this->category->validate()){
                $this->category->save(false);
            }else{
                $this->addErrors($this->category->getErrors());
                throw new Exception(Yii::t('system/error', 'Sorry, I can not save the category data'));
            }
        }

        protected function saveCharacteristics(){
            $characteristicsPost = Yii::$app->request->post('ProductCharacteristicModel');
            $oldId = [];
            $characteristics = [];
            if(!empty($characteristicsPost)){
                foreach($characteristicsPost as $index => $item){
                    $characteristics[$index] = ProductCharacteristicModel::findOne($item['id']);
                    if(!$characteristics[$index]){
                        $characteristics[$index] = new ProductCharacteristicModel(['category_id' => $this->category->id]);
                    }else{
                        $oldId[] = $item['id'];
                    }
                }
            }
            $deleteCharacteristic = $this->category->getProductCharacteristics()
                                                   ->where([
                                                               'not in',
                                                               'id',
                                                               $oldId
                                                           ])
                                                   ->all();
            if(!empty($deleteCharacteristic)){
                foreach($deleteCharacteristic as $item){
                    $item->delete();
                }
            }

            if(!empty($characteristics)){
                if(Model::loadMultiple($characteristics, Yii::$app->request->post()) && Model::validateMultiple($characteristics)){
                    foreach($characteristics as $item){
                        if(!$item->save(false)){
                            throw new Exception(Yii::t('system/error', 'Sorry, I can not save the characteristic data'));
                        }
                    }
                }else{
                    throw new Exception('Error to load characteristics');
                }
            }
        }


        public function getAllCategory(){
            $query = CategoryModel::find();
            $id = (!empty($this->category)) ? $this->category->id : null;
            if(!empty($id)){
                $query->andWhere([
                                     '!=',
                                     'id',
                                     $id
                                 ])
                      ->andWhere([
                                     '!=',
                                     'parent',
                                     $id
                                 ])
                      ->orWhere(['parent' => null])
                      ->andWhere([
                                     '!=',
                                     'id',
                                     $id
                                 ]);
            }

            return ArrayHelper::map($query->all(), 'id', 'title');
        }

        public function init(){
           if(!$this->category->isNewRecord){
               $parentCharacteristics = $this->category->parent0->productCharacteristics;
               $selfCharacteristics = $this->category->productCharacteristics;
               if(is_null($parentCharacteristics)){
                   $parentCharacteristics = [];
               }

               if(empty($selfCharacteristics)){
                   $selfCharacteristics = [];
               }
               $this->characteristics = ArrayHelper::merge($parentCharacteristics, $selfCharacteristics);
           }

           if(empty($this->characteristics)){
               $this->characteristics[] = new ProductCharacteristicModel();
           }
        }
    }