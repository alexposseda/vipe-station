<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_characteristic_lang}}".
 *
 * @property integer $id
 * @property integer $product_characteristic_id
 * @property integer $language
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property LanguageModel $language0
 * @property ProductCharacteristicModel $productCharacteristic
 */
class ProductCharacteristicLangModel extends ActiveRecord
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
        return '{{%product_characteristic_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_characteristic_id', 'language'], 'required'],
            [['product_characteristic_id', 'language', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => LanguageModel::className(), 'targetAttribute' => ['language' => 'id']],
            [['product_characteristic_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCharacteristicModel::className(), 'targetAttribute' => ['product_characteristic_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_characteristic_id' => 'Product Characteristic ID',
            'language' => 'Language',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage0()
    {
        return $this->hasOne(LanguageModel::className(), ['id' => 'language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCharacteristic()
    {
        return $this->hasOne(ProductCharacteristicModel::className(), ['id' => 'product_characteristic_id']);
    }
}
