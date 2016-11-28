<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property CategoryLang[] $categoryLangs
 * @property DeliveryLang[] $deliveryLangs
 * @property PaymentLang[] $paymentLangs
 * @property ProductCharacteristicLang[] $productCharacteristicLangs
 * @property ProductLang[] $productLangs
 * @property ProductOptionLang[] $productOptionLangs
 * @property StockLang[] $stockLangs
 */
class LanguageModel extends ActiveRecord
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
        return '{{%language}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'title'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['title'], 'string', 'max' => 20],
            [['code'], 'unique'],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryLangs()
    {
        return $this->hasMany(CategoryLang::className(), ['language' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryLangs()
    {
        return $this->hasMany(DeliveryLang::className(), ['language' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentLangs()
    {
        return $this->hasMany(PaymentLang::className(), ['language' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCharacteristicLangs()
    {
        return $this->hasMany(ProductCharacteristicLang::className(), ['language' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductLangs()
    {
        return $this->hasMany(ProductLang::className(), ['language' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductOptionLangs()
    {
        return $this->hasMany(ProductOptionLang::className(), ['language' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockLangs()
    {
        return $this->hasMany(StockLang::className(), ['language' => 'id']);
    }
}
