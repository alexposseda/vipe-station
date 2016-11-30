<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\ClientModel */
    /* @var $form yii\widgets\ActiveForm */

    $email_change = $model->isNewRecord || Yii::$app->user->can('adminAccess') ? ['readonly' => false] : ['readonly' => 'readonly'];
?>

<div class="client-model-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'email')
                             ->textInput($email_change) ?>

                    <?= $form->field($model, 'name')
                             ->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phones')
                             ->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'birthday')
                             ->textInput() ?>

                    <?= $form->field($model, 'delivery_data')
                             ->textarea(['rows' => 6]) ?>
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
