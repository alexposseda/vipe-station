<?php

    namespace common\components;

    use yii\caching\DbDependency;
    use yii\db\ActiveRecord;

    trait GetAllFromCacheTrait{

        /**
         * @return ActiveRecord[] | null
         */
        public static function getAll(){
            $dependency = new DbDependency([
                                               'sql' => 'SELECT MAX(updated_at) FROM '.self::tableName(),
                                           ]);

            return self::getDb()
                             ->cache(function(){
                                 return self::find()
                                                  ->all();
                             }, 3600, $dependency);
        }
    }