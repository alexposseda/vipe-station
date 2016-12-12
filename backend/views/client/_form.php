<?php

    use backend\assets\ClientAddressAsset;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\ClientModel */
    /* @var $form yii\widgets\ActiveForm */

    $email_change = $model->isNewRecord || Yii::$app->user->can('adminAccess') ? ['readonly' => false] : ['readonly' => 'readonly'];
    ClientAddressAsset::register($this);
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

                    <div class="panel panel-default">
                        <h4> <?=Yii::t('models/client', 'Delivery data')?> </h4>
                        <?= Html::activeHiddenInput($model, 'delivery_data')?>
                        <div class="address-input">
                            <?= Html::textInput('firstName', null, [
                                'placeholder' => Yii::t('models/client', 'First name'),
                                'style'       => ['width' => '15%']
                            ]) ?>
                            <?= Html::textInput('lastName', null, [
                                'placeholder' => Yii::t('models/client', 'Last name'),
                                'style'       => ['width' => '15%']
                            ]) ?>
                            <?= Html::textInput('city', null, [
                                'placeholder' => Yii::t('models/client', 'City'),
                                'style'       => ['width' => '15%']
                            ]) ?>
                            <?= Html::textInput('address', null, [
                                'placeholder' => Yii::t('models/client', 'Address'),
                                'style'       => ['width' => '38%']
                            ]) ?>
                            <?= Html::textInput('phone', null, [
                                'placeholder' => Yii::t('models/client', 'Phone'),
                                'style'       => ['width' => '15%']
                            ]) ?>
                        </div>

                    </div>
                    <div class="form-group">
                        <?= Html::button(Yii::t('system/view','Add').' '.Yii::t('models/client', 'Address'),['class' => 'add-delivery btn btn-primary']) ?>
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
