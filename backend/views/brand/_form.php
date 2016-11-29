<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BrandModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading"><?= Yii::t('system/view', 'Seo')?></div>
                <div class="panel-body"></div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('system/view','Create') : Yii::t('system/view','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>





</div>
