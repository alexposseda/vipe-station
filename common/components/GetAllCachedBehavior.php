<?php

    namespace common\components;

    use yii\base\Behavior;
    use yii\caching\DbDependency;
    use yii\db\ActiveRecord;

    class GetAllCachedBehavior extends Behavior{
        public $model;
        public $propertyName;

        public function getAll(){
            /** @var ActiveRecord $owner */
            $owner = $this->model;
            $dependency = new DbDependency([
                                               'sql' => 'SELECT MAX(updated_at) FROM '.$owner::tableName()
                                           ]);

            $entitys = $owner::getDb()
                                ->cache(function($db) use ($owner){
                                    return $owner::find()
                                                 ->all();
                                }, 3600, $dependency);

            $this->owner->{$this->propertyName} =  $entitys;
        }
    }