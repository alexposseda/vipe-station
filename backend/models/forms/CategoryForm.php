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
     * @property SeoModel                    $seo
     * @property CategoryModel               $category
     * @property  ProductCharacteristicModel [] $characteristic
     *
     */
    class CategoryForm extends Model{

        public $category;
        public $seo;
        public $characteristics;
        public $error;

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
            if( $this->category->load($data) && $this->seo->load($data) && Model::loadMultiple($this->characteristics,Yii::$app->request->post())){
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
                $count = count(Yii::$app->request->post('ProductCharacteristicModel'));
                $characteristicsPost = Yii::$app->request->post('ProductCharacteristicModel');
                /** @var ProductCharacteristicModel[] $characteristics */
                if(empty(/*$characteristics = */$this->category->productCharacteristics)){
                    for($i = 0; $i < $count; $i++){
                        $this->characteristics[$i]->category_id =$this->category->id;
                    }
                }/*elseif($count != count($characteristics)){
                    foreach($characteristicsPost as $characteristicPost){
                        $temp = $characteristics;
                        $characteristics = null;
                        foreach($temp as $characteristic){
                            if($characteristicPost->title == $characteristic->title){
                                $characteristics[] = $characteristic;
                            }
                        }
                    }
                }*/


                if(/*Model::loadMultiple($characteristics, Yii::$app->request->post()) && */Model::validateMultiple($this->characteristics)){
                    foreach($this->characteristics as $item){
                        if(!$item->save(false))
                            throw new Exception('Error to save characteristic')
                        ;
                    }
                }else
                    throw new Exception('Error to load characteristics');
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