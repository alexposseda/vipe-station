<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%seo}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $seo_block
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property CategoryModel $category
 * @property ProductModel $product
 * @property BrandModel $brand
 */
class SeoModel extends ActiveRecord
{
    public $link;

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
        return '{{%seo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['seo_block'],
                'string'
            ],
            [
                [
                    'created_at',
                    'updated_at'
                ],
                'integer'
            ],
            [
                [
                    'title',
                    'keywords'
                ],
                'string',
                'max' => 255
            ],
            [
                ['description'],
                'string',
                'max' => 500
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('models/seo', 'Title'),
            'keywords' => Yii::t('models/seo', 'Keywords'),
            'description' => Yii::t('models/seo', 'Description'),
            'seo_block' => Yii::t('models/seo', 'Seo Block'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoryModel::className(), ['seo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(ProductModel::className(), ['seo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(BrandModel::className(), ['seo_id' => 'id']);
    }

    public function canSave()
    {
        if (!empty($this->title) or !empty($this->keywords) or !empty($this->description) or !empty($this->seo_block)) {
            return true;
        }

        return false;
    }

    /**
     * @return BrandModel|CategoryModel|ProductModel
     */
    public function getParent()
    {
        if ($this->product) {
            $this->link = Url::to(['product/view', 'id' => $this->product->id]);
            return $this->product;
        }
        if ($this->category) {
            $this->link = Url::to(['category/view', 'id' => $this->category->id]);
            return $this->category;
        }
        if ($this->brand) {
            $this->link = Url::to(['brand/view', 'id' => $this->brand->id]);
            return $this->brand;
        }
    }
}
