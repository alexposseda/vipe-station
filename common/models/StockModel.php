<?php

    namespace common\models;

    use common\components\LanguageBehavior;
    use Yii;
    use yii\alexposseda\fileManager\FileManager;
    use yii\behaviors\SluggableBehavior;
    use yii\behaviors\TimestampBehavior;
    use yii\caching\ChainedDependency;
    use yii\caching\DbDependency;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%stock}}".
     *
     * @property integer               $id
     * @property integer               $policy_id
     * @property string                $title
     * @property string                $slug
     * @property string                $cover
     * @property string                $description
     * @property integer               $date_start
     * @property integer               $date_end
     * @property string                $status
     * @property string                $stock_value
     * @property integer               $created_at
     * @property integer               $updated_at
     *
     * @property ProductInStockModel[] $productInStocks
     * @property ProductModel[]        $products
     * @property StockPolicyModel      $policy
     */
    class StockModel extends ActiveRecord{

        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                [
                    'class'         => SluggableBehavior::className(),
                    'attribute'     => 'title',
                    'slugAttribute' => 'slug',
                ],
                TimestampBehavior::className(),
                [
                    'class'             => LanguageBehavior::className(),
                    'langModelName'     => StockLangModel::className(),
                    'relationFieldName' => 'stock_id',
                    't_category'        => 'models/stock',
                    'attributes'        => [
                        'title',
                        'description'
                    ],
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%stock}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['policy_id', 'date_start', 'date_end', 'created_at', 'updated_at'], 'integer'],
                [['title', 'slug', 'cover', 'description'], 'required'],
                [['description', 'status', 'stock_value'], 'string'],
                [['title', 'slug', 'cover'], 'string', 'max' => 255],
                [['title'], 'unique'],
                [['slug'], 'unique'],
                [
                    ['policy_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => StockPolicyModel::className(),
                    'targetAttribute' => ['policy_id' => 'id']
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'          => 'ID',
                'policy_id'   => Yii::t('models/stock', 'Policy'),
                'title'       => Yii::t('models/stock', 'Title'),
                'slug'        => Yii::t('models', 'Slug'),
                'cover'       => Yii::t('models/stock', 'Cover'),
                'description' => Yii::t('models/stock', 'Description'),
                'date_start'  => Yii::t('models/stock', 'Date Start'),
                'date_end'    => Yii::t('models/stock', 'Date End'),
                'status'      => Yii::t('models/stock', 'Status'),
                'stock_value' => Yii::t('models/stock', 'Stock Value'),
                'created_at'  => Yii::t('models', 'Created'),
                'updated_at'  => Yii::t('models', 'Last Update'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductInStocks(){
            $model = $this;

            return self::getDb()
                       ->cache(function() use ($model){
                           return $model->hasMany(ProductInStockModel::className(), ['stock_id' => 'id']);
                       }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM '.ProductInStockModel::tableName()]));
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProducts(){
            $model = $this;
            return self::getDb()
                       ->cache(function() use ($model){
                           return $model->hasMany(ProductModel::className(), ['id' => 'product_id'])
                                        ->viaTable(ProductInStockModel::tableName(), ['stock_id' => 'id']);
                       }, 0, new ChainedDependency([
                                                       'dependencies' => [
                                                           new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM '.ProductInStockModel::tableName()]),
                                                           new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM '.ProductModel::tableName()]),
                                                       ]
                                                   ]));
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPolicy(){
            $model = $this;

            return self::getDb()
                       ->cache(function() use ($model){
                           return $model->hasOne(StockPolicyModel::className(), ['id' => 'policy_id']);
                       }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM '.StockPolicyModel::tableName()]));
        }

        public function afterSave($insert, $changedAttributes){
            if(!empty($this->cover)){
                FileManager::getInstance()
                           ->removeFromSession(json_decode($this->cover)[0]);
            }
        }
    }
