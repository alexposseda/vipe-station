<?php

    namespace backend\models\forms;

    use yii\base\Model;

    abstract class SettingForm extends Model{

        abstract public function save();

        /**
         * Метод для получения моделей
         *
         * @param string $data json строка полученная из таблицы setting
         *
         * @return static[]
         */
        public static function getModels($data){
            $data = (!is_null($data) and !empty($data) and $data !== 'null') ? json_decode($data) : [];
            $className = static::className();
            $models = [];
            foreach($data as $item){
                $models[] = new $className($item);
            }

            return $models;
        }
    }