<?php
    /* @var $this yii\web\View */
    use yii\helpers\Html;

    /* @var $user common\models\UserIdentity */
    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
    <?= Yii::t('mailer/messages', 'Hello') ?>
        <?php if($user->client != null):?>
    <?=Html::encode($user->client->name)?>
    <?php endif;?>
    <?= Yii::t('mailer/messages', 'Follow the link below to reset your password') ?>:

    <?= $resetLink ?>