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
     * @property SeoModel                       $seo
     * @property CategoryModel                  $category
     * @property  ProductCharacteristicModel [] $characteristic
     *
     */
    class CategoryForm extends Model{

        public $category;
        public $seo;
        public $error;

        public $characteristic;

        public function rules(){
            return [
                [
                    'characteristic',
                    'safe'
                ]
            ];
        }


        /**
         * @param array $data
         *
         * @return bool
         */
        public function loadData(array $data){
            if($this->category->load($data) && $this->seo->load($data)){
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
                    if($this->seo->save()){
                        throw new Exception('error to save seo');
                    }
                    $this->category->seo_id = $this->seo->id;
                }else{
                    $this->category->seo_id = null;
                }

                if(!$this->category->save()){
                    throw new Exception('error to save category');
                }

                //todo сохранение характеристик
                $characteristicsPost = Yii::$app->request->post('ProductCharacteristicModel');
                $oldId = [];
                $characteristics=[];
                foreach($characteristicsPost as $index=>$item){
                    $characteristics[$index] = ProductCharacteristicModel::findOne($item['id']);

                    if(!$characteristics[$index]){
                        $characteristics[$index]=new ProductCharacteristicModel(['category_id' => $this->category->id]);
                    }else{
                        $oldId[] = $item['id'];
                    }
                }
                $deleteCharacteristic = $this->category->getProductCharacteristics()->where(['not in', 'id', $oldId])->all();
                if(!empty($deleteCharacteristic)){
                    foreach($deleteCharacteristic as $item)
                        $item->delete();
                }

                if(Model::loadMultiple($characteristics, Yii::$app->request->post()) && Model::validateMultiple($characteristics)){
                    foreach($characteristics as $item){
                        if(!$item->save(false)){
                            throw new Exception('Error to save characteristic');
                        }
                    }
                }else{
                    throw new Exception('Error to load characteristics');
                }
                $transaction->commit();

                return true;
            }catch(Exception $e){
                $this->error = $e->getMessage();
                $transaction->rollBack();

                return false;
            }
        }

        public function getAllCategory(){
            $query = CategoryModel::find();
            $id = (!empty($this->category)) ? $this->category->id : null;
            if(!$this->category->isNewRecord){
                $query->andWhere([
                                     '!=',
                                     'id',
                                     $this->category->id
                                 ])
                      ->andWhere([
                                     '!=',
                                     'parent',
                                     $this->category->id
                                 ]);
            }

            return ArrayHelper::map($query->all(), 'id', 'title');
        }

    }