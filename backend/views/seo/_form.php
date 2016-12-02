<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\SeoModel */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="seo-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')
        ->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'keywords')
        ->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'description')
             ->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'seo_block')
             ->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                               ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
