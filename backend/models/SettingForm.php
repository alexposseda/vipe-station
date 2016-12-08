<?php

    namespace backend\models;

    use yii\base\Model;

    abstract class SettingForm extends Model{

        abstract public function save();
    }