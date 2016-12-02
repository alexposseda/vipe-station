<?php

    /* @var $this yii\web\View */
    /* @var $form yii\bootstrap\ActiveForm */
    /* @var $model \common\models\forms\SignupForm */

    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;

    $this->title = Yii::t('models/authorize', 'Signup');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?=Yii::t('models/authorize','Please fill out the following fields to signup:')?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password_repeat')
                     ->passwordInput() ?>

            <?= $form->field($model, 'password')
                     ->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('models/authorize', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
