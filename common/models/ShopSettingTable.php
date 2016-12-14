<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%setting}}".
     *
     * @property integer $key
     * @property string  $value
     * @property integer $created_at
     * @property integer $updated_at
     */
    class ShopSettingTable extends ActiveRecord{

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
            return '{{%setting}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'key'
                    ],
                    'required'
                ],
                [
                    [
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    [
                        'key',
                        'value'
                    ],
                    'string'
                ],
                [
                    ['key'],
                    'unique'
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'key'        => 'Key',
                'value'      => 'Value',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ];
        }

        /**
         * метод возвращает экземпляр класса
         *
         * @param string $setting
         *
         * @return ShopSettingTable
         */
        public static function getSetting($setting){
            $set = self::find()
                       ->where(['key' => $setting])
                       ->one();
            if(!$set){
                $set = new self();
                $set->key = $setting;
            }

            return $set;
        }

        /**
         * Метод возвращает значение переданной настройки
         *
         * @param string $key
         *
         * @return null|string
         */
        public static function getSettingValue($key){
            $setting = self::getSetting($key);
            if(is_null($setting)){
                return null;
            }

            return $setting->value;
        }
    }
