<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_characteristic_item}}".
 *
 * @property integer $id
 * @property integer $characteristic_id
 * @property integer $product_id
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductCharacteristic $characteristic
 * @property Product $product
 */
class ProductCharacteristicItemModel extends ActiveRecord
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
        return '{{%product_characteristic_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['characteristic_id', 'product_id', 'value'], 'required'],
            [['characteristic_id', 'product_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['characteristic_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCharacteristic::className(), 'targetAttribute' => ['characteristic_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristic()
    {
        return $this->hasOne(ProductCharacteristic::className(), ['id' => 'characteristic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
