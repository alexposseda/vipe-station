<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ProductSearchModel */
/* @var $form yii\widgets\ActiveForm */
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

    <?php // echo $form->field($model, 'gallery') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'base_price') ?>

    <?php // echo $form->field($model, 'base_quantity') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'sales') ?>

    <?php // echo $form->field($model, 'views') ?>

    <?php // echo $form->field($model, 'seo_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'brand_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
