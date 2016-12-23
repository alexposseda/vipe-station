<?php

    namespace backend\models\forms;

    use yii\alexposseda\fileManager\FileManager;
    use yii\base\Model;
    use yii\web\UploadedFile;

    class SocialItemForm extends Model{
        public $link;
        public $title;
        public $iconFile;
        public $index = 0;

        public $icon = '';

        public function rules(){
            return [
                [
                    [
                        'link',
                        'title'
                    ],
                    'required'
                ],
                [
                    'iconFile',
                    'file',
                    'skipOnEmpty' => true,
                    'extensions'  => 'png, jpg, gif',
                    'maxSize'     => 1024 * 50,
                    'maxFiles'    => 1
                ],
                [
                    'link',
                    'url'
                ],
                [
                    'title',
                    'string',
                    'max' => 255
                ]
            ];
        }

        public function attributeLabels(){
            return [
                'link' => 'Link',
                'iconFile' => 'Icon',
                'icon' => 'Icon',
                'title' => 'Title'
            ];
        }

        public function beforeValidate(){
            $this->iconFile = UploadedFile::getInstance($this, '['.$this->index.']iconFile');

            return parent::beforeValidate();
        }

        public function afterValidate(){
            parent::afterValidate();
            if(!is_null($this->iconFile)){
                $this->saveIcon();
            }
        }

        protected function saveIcon(){
            $iconFileName = time();
            $f_manager = FileManager::getInstance();

            $f_manager->createDirectory('socials');

            $path = $f_manager->getStoragePath().'socials/'.$iconFileName.'.'.$this->iconFile->extension;

            if($this->iconFile->saveAs($path)){
                $this->icon = '/socials/'.$iconFileName.'.'.$this->iconFile->extension;
            }
        }

        public function getDataAsArray(){
            return [
                'title' => $this->title,
                'icon'  => $this->icon,
                'link'  => $this->link
            ];
        }
    }