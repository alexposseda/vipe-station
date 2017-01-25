<?php

    use backend\assets\ClientAddressAsset;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use yii\widgets\MaskedInput;

    /**
     * @var $this  yii\web\View
     * @var $model common\models\ClientModel
     * @var $form  yii\widgets\ActiveForm
     */

    $email_change = $model->isNewRecord || Yii::$app->user->can('adminAccess') ? ['readonly' => false] : ['readonly' => 'readonly'];
    ClientAddressAsset::register($this);

?>

<div class="client-model-form">

    <?php $form = ActiveForm::begin(['id' => 'client_form']); ?>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'email')
                             ->textInput($email_change) ?>

                    <?= $form->field($model, 'name')
                             ->textInput(['maxlength' => true]) ?>

                    <div class="form-group phones">
                        <label class="control-label"><?= $model->getAttributeLabel('phones') ?></label>

                            <?php foreach($model->phones_arr as $index => $phone): ?>
                                <div class="form-inline">
                                    <?= $form->field($phone, "phones_arr[$index]")
                                             ->widget(MaskedInput::className(), ['mask' => '(999)999-99-99'])
                                             ->label(false) ?>
<!--                                    --><?//= MaskedInput::widget([
//                                                                'model'     => $model,
//                                                                'attribute' => 'phones_arr['.$index.']',
//                                                                'mask'      => '(999)999-99-99'
//                                                            ]) ?>

                                    <button type="button" class="btn btn-sm btn-danger del-phone"
                                            data-index="<?= $index ?>"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                            <?php endforeach; ?>



                    </div>
                    <?= Html::button('Add Phone', ['id' => 'btn_add_phone']) ?>

                    <?= $form->field($model, 'birthday')
                             ->textInput() ?>

                    <div class="form-group delivery">
                        <label class="control-label"> <?= Yii::t('models/client', 'Delivery data') ?> </label>
                        <div class="address-input">


                            <?php foreach($model->deliveryData as $index => $data) : ?>
                                <div class="form-inline">
                                    <?= $form->field($data, "[$index]f_name")
                                             ->textInput(['placeholder' => Yii::t('models/client', 'First name'),])
                                             ->label(false) ?>
                                    <?= $form->field($data, "[$index]l_name")
                                             ->textInput(['placeholder' => Yii::t('models/client', 'Last name'),])
                                             ->label(false) ?>
                                    <?= $form->field($data, "[$index]city")
                                             ->textInput(['placeholder' => Yii::t('models/client', 'City'),])
                                             ->label(false) ?>
                                    <?= $form->field($data, "[$index]address")
                                             ->textInput(['placeholder' => Yii::t('models/client', 'Address'),])
                                             ->label(false) ?>
                                    <?= $form->field($data, "[$index]phone")
                                             ->widget(MaskedInput::className(), ['mask' => '(999)999-99-99'])
                                             ->label(false) ?>


                                    <button type="button" class="btn btn-sm btn-danger del-delivery"
                                            data-index="<?= $index ?>"><span class="glyphicon glyphicon-remove"></span></button>

                                </div>
                            <?php endforeach; ?>


                        </div>

                    </div>

                    <div class="panel-footer text-left">
                        <button type="button" class="btn btn-primary" id="add-delivery"><?= (Yii::t('system/view', 'Add').' '.Yii::t('models/client',
                                                                                                                                     'Address')) ?></button>
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
