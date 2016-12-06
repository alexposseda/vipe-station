<?php

    namespace backend\models;

    use common\models\BrandModel;
    use common\models\SeoModel;
    use Yii;
    use yii\alexposseda\fileManager\FileManager;
    use yii\base\Model;
    use yii\db\Exception;

    /**
     * Class BrandForm
     * @package backend\models
     *
     * @property SeoModel   $seo
     * @property BrandModel $brand
     */
    class  BrandForm extends Model{
        public $brand;
        public $seo;
        public $error;

        /**
         * @param array $data
         *
         * @return bool
         */
        public function loadData(array $data){
            if($this->brand->load($data) && $this->seo->load($data)){
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
                    $this->brand->seo_id = $this->seo->id;
                }else{
                    $this->brand->seo_id = null;
                }


                if(!$this->brand->save()){
                    throw new Exception('error to save brand');
                }

                if(!empty($this->brand->cover)){
                    FileManager::getInstance()
                               ->removeFromSession(json_decode($this->brand->cover)[0]);
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