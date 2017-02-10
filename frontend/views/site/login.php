<?php

    /**
     * @var $this yii\web\View
     * @var $form yii\bootstrap\ActiveForm
     * @var $model \common\models\forms\LoginForm
     */

    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;

    $this->title = Yii::t('models/authorize', 'Login');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('models/authorize', 'Please fill out the following fields to login:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'email')
                     ->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')
                     ->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')
                     ->checkbox() ?>
            <div style="color:#999;margin:1em 0">
                <?=Yii::t('models/authorize','If you forgot your password you can')?> <?= Html::a(Yii::t('models/authorize','reset it'), ['site/request-password-reset']) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('models/authorize', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <div class="form-group">
                <?= Html::a(Yii::t('models/authorize', 'Signup'), ['site/signup'], ['class' => 'btn btn-info']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
