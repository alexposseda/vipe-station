<?php

    use backend\assets\ClientAddressAsset;
    use yii\helpers\Html;
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

    <?php $form = ActiveForm::begin(); ?>
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
                        <?php if(count($model->phones_arr)): ?>
                            <?php foreach($model->phones_arr as $index => $phone): ?>
                                <?= MaskedInput::widget([
                                                            'model'     => $model,
                                                            'attribute' => 'phones_arr['.$index.']',
                                                            'mask'      => '(999)999-99-99'
                                                        ]) ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?= MaskedInput::widget([
                                                        'model'     => $model,
                                                        'attribute' => 'phones_arr[0]',
                                                        'mask'      => '(999)999-99-99'
                                                    ]) ?>
                        <?php endif; ?>
                        <?= Html::button('Add Phone', ['id' => 'btn_add_phone']) ?>
                    </div>


                    <?= $form->field($model, 'birthday')
                             ->textInput() ?>

                    <div class="form-group delivery">
                        <label class="control-label"> <?= Yii::t('models/client', 'Delivery data') ?> </label>
                        <div class="address-input">
                            <div class="form-inline">
                                <?php if(count($model->delivery_data_arr)): ?>
                                    <?php foreach($model->delivery_data_arr as $index => $data) : ?>
                                        <?= $form->field($model, 'delivery_data_arr['.$index.'][f_name]')
                                                 ->textInput(['placeholder' => Yii::t('models/client', 'First name'),])
                                                 ->label(false) ?>
                                        <?= $form->field($model, 'delivery_data_arr['.$index.'][l_name]')
                                                 ->textInput(['placeholder' => Yii::t('models/client', 'Last name'),])
                                                 ->label(false) ?>
                                        <?= $form->field($model, 'delivery_data_arr['.$index.'][city]')
                                                 ->textInput(['placeholder' => Yii::t('models/client', 'City'),])
                                                 ->label(false) ?>
                                        <?= $form->field($model, 'delivery_data_arr['.$index.'][address]')
                                                 ->textInput(['placeholder' => Yii::t('models/client', 'Address'),])
                                                 ->label(false) ?>

                                        <?= MaskedInput::widget([
                                                                    'model'     => $model,
                                                                    'attribute' => 'delivery_data_arr['.$index.']->phone',
                                                                    'mask'      => '(999)999-99-99',
                                                                ]) ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?= $form->field($model, 'delivery_data_arr[0][f_name]')
                                             ->textInput(['placeholder' => Yii::t('models/client', 'First name'),])
                                             ->label(false) ?>
                                    <?= $form->field($model, 'delivery_data_arr[0][l_name]')
                                             ->textInput(['placeholder' => Yii::t('models/client', 'Last name'),])
                                             ->label(false) ?>
                                    <?= $form->field($model, 'delivery_data_arr[0][city]')
                                             ->textInput(['placeholder' => Yii::t('models/client', 'City'),])
                                             ->label(false) ?>
                                    <?= $form->field($model, 'delivery_data_arr[0][address]')
                                             ->textInput(['placeholder' => Yii::t('models/client', 'Address'),])
                                             ->label(false) ?>

                                    <?= MaskedInput::widget([
                                                                'model'     => $model,
                                                                'attribute' => 'delivery_data_arr[0][phone]',
                                                                'mask'      => '(999)999-99-99',
                                                            ]) ?>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <?= Html::button(Yii::t('system/view', 'Add').' '.Yii::t('models/client', 'Address'),
                                         ['class' => 'add-delivery btn btn-primary']) ?>
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
