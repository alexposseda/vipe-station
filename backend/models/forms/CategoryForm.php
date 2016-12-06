<?php

    namespace backend\models\forms;

    use Yii;
    use yii\base\Model;
    use yii\db\Exception;
    use common\models\CategoryModel;
    use common\models\SeoModel;

    /**
     * Class CategoryForm
     * @package backend\models\forms
     *
     * @property SeoModel      $seo
     * @property CategoryModel $category
     */
    class CategoryForm extends Model{

        public $category;
        public $seo;
        public $error;

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

                $transaction->commit();
                return true;
            }catch(Exception $e){
                $this->error = $e->getMessage();
                $transaction->rollBack();
                return false;
            }
        }

    }