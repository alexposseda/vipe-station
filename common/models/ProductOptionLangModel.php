<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_option_lang}}".
 *
 * @property integer $id
 * @property integer $product_option_id
 * @property integer $language
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property LanguageModel $language0
 * @property ProductOptionModel $productOption
 */
class ProductOptionLangModel extends ActiveRecord
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
        return '{{%product_option_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_option_id', 'language'], 'required'],
            [['product_option_id', 'language', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => LanguageModel::className(), 'targetAttribute' => ['language' => 'id']],
            [['product_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductOptionModel::className(), 'targetAttribute' => ['product_option_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_option_id' => 'Product Option ID',
            'language' => 'Language',
            'value' => 'Value',
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
    public function getProductOption()
    {
        return $this->hasOne(ProductOptionModel::className(), ['id' => 'product_option_id']);
    }
}
