<?php

    namespace backend\models;

    use yii\base\Model;

    class DeliverPayModel extends Model{
        public $logo;
        public $title;
        public $lang;
        public $desc;


        public function rules(){
            return [
                [
                    'logo',
                    'title',
                    'lang',
                    'desc'
                ],
                'string'
            ];
        }

        public function init(){
            $this->logo[0]=$this->getSetting('delivery');
        }

        public function save(){

            return false;
        }
    }