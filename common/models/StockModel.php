<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%stock}}".
 *
 * @property integer $id
 * @property integer $policy_id
 * @property string $title
 * @property string $slug
 * @property string $cover
 * @property string $description
 * @property integer $date_start
 * @property integer $date_end
 * @property string $status
 * @property string $stock_value
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductInStock[] $productInStocks
 * @property Product[] $products
 * @property StockPolicy $policy
 */
class StockModel extends ActiveRecord
{

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',
            ],
            TimestampBehavior::className(),
            ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['policy_id', 'date_start', 'date_end', 'created_at', 'updated_at'], 'integer'],
            [['title', 'slug', 'cover', 'description'], 'required'],
            [['description', 'status', 'stock_value'], 'string'],
            [['title', 'slug', 'cover'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['slug'], 'unique'],
            [['policy_id'], 'exist', 'skipOnError' => true, 'targetClass' => StockPolicy::className(), 'targetAttribute' => ['policy_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'policy_id' => 'Policy ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'cover' => 'Cover',
            'description' => 'Description',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'status' => 'Status',
            'stock_value' => 'Stock Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductInStocks()
    {
        return $this->hasMany(ProductInStock::className(), ['stock_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('{{%product_in_stock}}', ['stock_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicy()
    {
        return $this->hasOne(StockPolicy::className(), ['id' => 'policy_id']);
    }
}
