<?php

use common\models\BrandModel;
use common\models\CategoryModel;
use yii\caching\DbDependency;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\search\ProductSearchModel
 * @var $form yii\widgets\ActiveForm
 */
$allCategory = CategoryModel::getDb()
    ->cache(function () {
        return CategoryModel::find()
            ->all();
    }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM' . CategoryModel::tableName()]));

$allBrand = BrandModel::getDb()
    ->cache(function () {
        return BrandModel::find()
            ->all();
    }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM' . BrandModel::tableName()]));
$allBrandMap = ArrayHelper::map($allBrand, 'id', 'title');
$allCategoryMap = ArrayHelper::map($allCategory, 'id', 'title');
?>

<div class="product-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'category_id')->dropDownList($allCategoryMap,['prompt'=>Yii::t('system/view','Select').' '.Yii::t('models/category','Category')])->label(Yii::t('models', 'Category')) ?>
    <?= $form->field($model, 'brand_id')->dropDownList($allBrandMap,['prompt'=>Yii::t('system/view','Select').' '.Yii::t('models','Brand')])->label(Yii::t('models', 'Brand')) ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'price')->label($model->getAttributeLabel('base_price'))->textInput(['placeholder'=>'0;100']) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('system/view', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('system/view', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
