<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%stock_lang}}".
 *
 * @property integer $id
 * @property integer $stock_id
 * @property integer $language
 * @property string $title
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property LanguageModel $language0
 * @property StockModel $stock
 */
class StockLangModel extends ActiveRecord
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
        return '{{%stock_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock_id', 'language'], 'required'],
            [['stock_id', 'language', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => LanguageModel::className(), 'targetAttribute' => ['language' => 'code']],
            [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => StockModel::className(), 'targetAttribute' => ['stock_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stock_id' => 'Stock ID',
            'language' => 'Language',
            'title' => 'Title',
            'description' => 'Description',
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
    public function getStock()
    {
        return $this->hasOne(StockModel::className(), ['id' => 'stock_id']);
    }
}
