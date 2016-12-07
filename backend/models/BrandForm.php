<?php

    namespace backend\models;

    use common\models\BrandModel;
    use common\models\SeoModel;
    use Exception;
    use Yii;
    use yii\alexposseda\fileManager\FileManager;
    use yii\base\Model;

    /**
     * Class BrandForm
     *
     * модель для Создания | Обновления бренда
     *
     * @package backend\models
     *
     * @property SeoModel   $seo
     * @property BrandModel $brand
     */
    class BrandForm extends Model{
        public    $brand;
        public    $seo;

        /**
         * Сохраняем бренд
         *
         * @return bool
         */
        public function save(){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $this->saveSeo();
                $this->saveBrand();

                $transaction->commit();
                return true;
            }catch(Exception $e){
                $transaction->rollBack();
                Yii::$app->session->setFlash('brandFormError', $e->getMessage());
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
                    $this->brand->seo_id = $this->seo->id;
                }else if(!$this->seo->isNewRecord){
                    $this->seo->delete();
                    $this->brand->seo_id = null;
                }else{
                    $this->brand->seo_id = null;
                }
            }else{
                $this->addErrors($this->seo->getErrors());
                throw new Exception(Yii::t('system/error', 'Sorry, I can not save the seo data'));
            }
        }

        /**
         * Сохраняем бренд
         *
         * @throws Exception
         */
        protected function saveBrand(){
            if($this->brand->load(Yii::$app->request->post()) && $this->brand->validate()){
                $this->brand->save(false);
                if(!empty($this->brand->cover)){
                    FileManager::getInstance()->removeFromSession(json_decode($this->brand->cover)[0]);
                }
            }else{
                $this->addErrors($this->brand->getErrors());
                throw new Exception(Yii::t('system/error', 'Sorry, I can not save the brand data'));
            }
        }


    }