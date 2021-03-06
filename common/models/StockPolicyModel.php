<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\caching\DbDependency;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%stock_policy}}".
     *
     * @property integer      $id
     * @property string       $name
     * @property integer      $created_at
     * @property integer      $updated_at
     *
     * @property StockModel[] $stocks
     */
    class StockPolicyModel extends ActiveRecord{

        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                TimestampBehavior::className(),
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%stock_policy}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['name'], 'required'],
                [['created_at', 'updated_at'], 'integer'],
                [['name'], 'string', 'max' => 255],
                [['name'], 'unique'],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'         => 'ID',
                'name'       => 'Name',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getStocks(){
            return $this->hasMany(StockModel::className(), ['policy_id' => 'id']);
        }

        public static function getAllPolicy(){
            return self::getDb()
                       ->cache(function(){
                           return self::find()
                                      ->all();
                       }, 0, new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.self::tableName()]));
        }
    }
