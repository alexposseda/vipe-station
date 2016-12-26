<?php

    namespace backend\models\forms;

    use yii\base\Model;

    abstract class SettingForm extends Model{

        abstract public function save();

        /**
         * Метод для получения моделей
         *
         * @param string $data json строка полученная из таблицы setting
         * @param string $modelName
         *
         * @return static[]
         */
        public static function getModels($modelName, $data){
            $data = (!is_null($data) and !empty($data) and $data !== 'null') ? json_decode($data) : [];
            $models = [];
            foreach($data as $item){
                $models[] = new $modelName($item);
            }

            return $models;
        }
    }