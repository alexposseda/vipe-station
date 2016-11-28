<?php

namespace common\components;

use common\models\Language;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class MultyLangBehavior extends Behavior{
    public $attributes;
    public $relationName;

    public function events(){
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'changeLangAttributes',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveLangModels',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateLangModels',
        ];
    }

    public function changeLangAttributes(){
        if(Yii::$app->sourceLanguage != Yii::$app->language){
            $models = $this->getLangModels();
            if($models){
                foreach($models as $langModel){
                    if($langModel->language0->code == Yii::$app->language){
                        foreach($this->attributes as $attr){
                            $this->owner->$attr = $langModel->$attr;
                        }
                        break;
                    }
                }
            }
        }
    }

    public function getLangModels(){
        return $this->owner->{lcfirst($this->owner->formName()).'Langs'};
    }

    public function getNecessaryLangModels(){
        $modelName = '\common\models\\'.$this->owner->formName().'Lang';
        //todo add baseLangActiveRecordModel
        $availableLangs = Language::find()->where(['!=', 'code', Yii::$app->sourceLanguage])->all();
        $langModels = [];
        foreach($availableLangs as $lang){
            $langModels[] = new $modelName(['language' => $lang->id]);
        }
        return $langModels;
    }

    public function getLangModelsForForm(){
        $availableModels = $this->getLangModels();
        $necessaryModels = $this->getNecessaryLangModels();

        foreach($necessaryModels as $k => $nm){
            foreach($availableModels as $av){
                if($av->language == $nm->language){
                    $necessaryModels[$k] = $av;
                }
            }
        }

        return $necessaryModels;
    }

    public function saveLangModels(){
        $modelName = $this->owner->className().'Lang';
        $data = Yii::$app->request->post($this->owner->formName().'Lang');
        foreach($data as $d){
            $model = new $modelName();
            $model->{$this->relationName} = $this->owner->id;
            $model->language = $d['lang'];
            $canSave = false;
            foreach($this->attributes as $attr){
                if(!empty($d[$attr])){
                    $model->$attr = $d[$attr];
                    $canSave = true;
                }
            }
            if($canSave){
                $model->save();
            }
        }
    }

    public function updateLangModels(){
        $modelName = $this->owner->className().'Lang';
        $data = Yii::$app->request->post($this->owner->formName().'Lang');
        $availableLangModels = $this->getLangModels();

        foreach($data as $d){
            $createModel = true;
            foreach($availableLangModels as $alm){
                if($alm->language0->id == $d['lang']){
                    $emptyField = 0;
                    foreach($this->attributes as $attr){
                        $alm->$attr = $d[$attr];
                        if(empty($d[$attr])){
                            $emptyField++;
                        }
                    }
                    if(count($this->attributes) == $emptyField){
                        $alm->delete();
                    }else{
                        $alm->save();
                    }

                    $createModel = false;
                    break;
                }
            }
            if($createModel){
                $model = new $modelName();
                $model->{$this->relationName} = $this->owner->id;
                $model->language = $d['lang'];
                $canSave = false;
                foreach($this->attributes as $attr){
                    if(!empty($d[$attr])){
                        $model->$attr = $d[$attr];
                        $canSave = true;
                    }
                }
                if($canSave){
                    $model->save();
                }
            }

        }

    }

}