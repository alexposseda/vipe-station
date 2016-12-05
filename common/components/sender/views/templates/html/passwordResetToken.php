<?php
    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $user common\models\UserIdentity */
    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p><?= Yii::t('mailer/messages', 'Hello') ?>
    <?php if($user->client != null) {echo 'Html::encode($user->client->name)';}?>,</p>
    <p><?=Yii::t('mailer/messages','Follow the link below to reset your password')?>:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>