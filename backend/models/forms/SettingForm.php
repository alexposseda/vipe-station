<?php

    namespace backend\models\forms;

    use yii\base\Model;

    abstract class SettingForm extends Model{

        abstract public function save();
    }