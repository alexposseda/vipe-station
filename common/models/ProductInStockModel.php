<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_in_stock}}".
 *
 * @property integer $stock_id
 * @property integer $product_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductModel $product
 * @property StockModel $stock
 */
class ProductInStockModel extends ActiveRecord
{

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_in_stock}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock_id', 'product_id'], 'required'],
            [['stock_id', 'product_id', 'created_at', 'updated_at'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductModel::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => StockModel::className(), 'targetAttribute' => ['stock_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stock_id' => 'Stock ID',
            'product_id' => 'Product ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(ProductModel::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(StockModel::className(), ['id' => 'stock_id']);
    }
}
