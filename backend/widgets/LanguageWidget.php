<?php

    namespace backend\widgets;

    use common\models\LanguageModel;
    use Yii;
    use yii\base\ErrorException;
    use yii\base\Widget;
    use yii\bootstrap\Tabs;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;

    class LanguageWidget extends Widget{
        public $form;
        public $attributes;
        public $baseLang = [
            'code'  => 'ru',
            'title' => 'Русский'
        ];
        public $model;

        protected $_langModels;
        protected $_languages;

        public function init(){
            parent::init();
            $this->_languages = ArrayHelper::map(LanguageModel::getAll(), 'code', 'title');
            $this->_langModels = $this->model->getAvailableLangs();
        }

        public function run(){
            $items = [];
            $items[] = [
                'label'   => $this->baseLang['title'],
                'content' => $this->getBaseLangFields()
            ];


            for($i = 0; $i < count($this->_langModels); $i++){
                $items[] = [
                    'label'   => $this->_languages[$this->_langModels[$i]->language],
                    'content' => $this->getLangsFields($this->_langModels[$i], $i)
                ];
            }

            return Tabs::widget([
                                    'items' => $items
                                ]);
        }

        protected function getBaseLangFields(){
            $content = '';
            foreach($this->attributes as $attr){
                $content .= $this->form->field($this->model, $attr['name'])
                                       ->{$attr['type']}($attr['options'])
                                       ->label(Yii::t('models/brand', $this->model->getAttributeLabel($attr['name']), [], $this->baseLang['code']));
            }

            return $content;
        }

        protected function getLangsFields($model, $index){
            $content = Html::activeHiddenInput($model, '['.$index.']language', ['value' => $model->language]);
            foreach($this->attributes as $attr){
                $content .= $this->form->field($model, '['.$index.']'.$attr['name'])
                                       ->{$attr['type']}($attr['options'])
                                       ->label(Yii::t($this->model->getTcategory(), $this->model->getAttributeLabel($attr['name']), [], $model->language));
            }

            return $content;
        }
    }