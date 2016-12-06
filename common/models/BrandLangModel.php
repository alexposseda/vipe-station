<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%brand_lang}}".
 *
 * @property integer $id
 * @property integer $brand_id
 * @property string $language
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BrandModel $brand
 * @property LanguageModel $language0
 */
class BrandLangModel extends ActiveRecord
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
        return '{{%brand_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_id', 'language'], 'required'],
            [['brand_id', 'created_at', 'updated_at'], 'integer'],
            [['language'], 'string', 'max' => 4],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => BrandModel::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => LanguageModel::className(), 'targetAttribute' => ['language' => 'code']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'language' => 'Language',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage0()
    {
        return $this->hasOne(Language::className(), ['code' => 'language']);
    }
}
