<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_option}}".
 *
 * @property integer $id
 * @property integer $characteristic_id
 * @property integer $product_id
 * @property string $value
 * @property double $delta_price
 * @property integer $quantity
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductModel $product
 * @property ProductCharacteristicModel $characteristic
 */
class ProductOptionModel extends ActiveRecord
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
        return '{{%product_option}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['characteristic_id', 'product_id', 'value'], 'required'],
            [['characteristic_id', 'product_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
            [['delta_price'], 'number'],
            [['value'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductModel::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['characteristic_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCharacteristicModel::className(), 'targetAttribute' => ['characteristic_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'characteristic_id' => 'Characteristic ID',
            'product_id' => 'Product ID',
            'value' => 'Value',
            'delta_price' => 'Delta Price',
            'quantity' => 'Quantity',
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
    public function getCharacteristic()
    {
        return $this->hasOne(ProductCharacteristicModel::className(), ['id' => 'characteristic_id']);
    }
}
