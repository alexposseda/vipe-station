<?php

    use backend\widgets\LanguageWidget;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\DeliveryModel */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= LanguageWidget::widget([
                                                   'form'       => $form,
                                                   'model'      => $model,
                                                   'attributes' => [
                                                       [
                                                           'name'    => 'name',
                                                           'type'    => 'textInput',
                                                           'options' => ['maxlength' => true]
                                                       ],
                                                       [
                                                           'name'    => 'description',
                                                           'type'    => 'textarea',
                                                           'options' => ['rows' => 6]
                                                       ]
                                                   ]
                                               ]) ?>
                    <?= $form->field($model, 'price')
                             ->textInput() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                               ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
