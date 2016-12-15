<?php

    namespace backend\models\forms;

    use common\models\ShopSettingTable;
    use yii\alexposseda\fileManager\FileManager;
    use yii\web\UploadedFile;

    class BannerForm extends SettingForm{
        public $bannerFile;
        public $bannerTitle;

        public function init(){
            parent::init();

            $data = ShopSettingTable::getSettingValue('banner');
            if($data){
                $data = json_decode($data);
                $this->bannerFile = $data->bannerFile;
                $this->bannerTitle = $data->bannerTitle;
            }
        }

        public function rules(){
            return [
                [
                    'bannerTitle',
                    'required'
                ],
                [
                    [
                        'bannerTitle'
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    'bannerFile',
                    'file',
                    'skipOnEmpty' => false,
                    'extensions'  => 'png, jpg, gif',
                    'maxSize'     => 1024 * 1024,
                    'maxFiles'    => 1
                ],
            ];
        }

        public function attributeLabels(){
            return [
                'bannerFile'  => 'Banner Picture',
                'bannerTitle' => 'Banner Title'
            ];
        }

        public function beforeValidate(){
            $this->bannerFile = UploadedFile::getInstance($this, 'bannerFile');
            return parent::beforeValidate();
        }

        public function afterValidate(){
            if(!is_null($this->bannerFile)){
                $this->saveIcon();
            }
        }

        protected function saveIcon(){
            $iconFileName = time();
            $f_manager = FileManager::getInstance();

            $f_manager->createDirectory('banner');

            $path = $f_manager->getStoragePath().'banner/'.$iconFileName.'.'.$this->bannerFile->extension;

            if($this->bannerFile->saveAs($path)){
                $this->bannerFile = '/banner/'.$iconFileName.'.'.$this->bannerFile->extension;
            }
        }
        public function save(){
            $model = ShopSettingTable::getSetting('banner');
            $model->value = json_encode([
                'bannerTitle' => $this->bannerTitle,
                'bannerFile' => $this->bannerFile,
                                        ]);
            if(!$model->save()){
                $this->addErrors($model->getErrors());
            }
        }
    }