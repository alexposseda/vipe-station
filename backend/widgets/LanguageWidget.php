<?php

    namespace backend\widgets;

    use common\models\LanguageModel;
    use yii\base\ErrorException;
    use yii\base\Widget;
    use yii\bootstrap\Tabs;

    class LanguageWidget extends Widget{
        public $form;
        public $attributes;
        public $baseLang = [
            'code'  => 'ru',
            'title' => 'Русский'
        ];
        public $model;

        protected $_languages;

        public function init(){
            parent::init();
            $this->_languages = LanguageModel::getAll();
        }

        public function run(){
            $items = [];
            $items[] = [
                'label' => $this->baseLang['title'],
                'content' => $this->getBaseLangFields()
            ];

            foreach($this->_languages as $lang){
                $items[] = [
                    'label' => $lang->title,
                    'content' => $this->getLangsFields($lang->code)
                ];
            }

            return Tabs::widget([
                                    'items' => $items
                                ]);
        }

        protected function renderField($model, $attr){
            return $this->form->field($model, $attr['name'])
                              ->{$attr['type']}($attr['options']);
        }

        protected function getBaseLangFields(){
            $content = '';
            foreach($this->attributes as $attr){
                $content .= $this->renderField($this->model, $attr);
            }

            return $content;
        }

        protected function getLangsFields($langCode){
            $model = $this->model->getLangModel($langCode);
            if(is_null($model)){
                throw new ErrorException('Lang Code'.$langCode.' not found!');
            }

            $content = '';
            foreach($this->attributes as $attr){
                $content .= $this->renderField($model, $attr);
            }

            return $content;
        }
    }