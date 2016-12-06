<?php
    /* @var $this yii\web\View */
    /* @var $user common\models\UserIdentity */
    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
    <?= Yii::t('mailer/messages', 'Hello') ?>
        <?php if($user->client != null) {echo 'Html::encode($user->client->name)';}?>,
    <?= Yii::t('mailer/messages', 'Follow the link below to reset your password') ?>:

    <?= $resetLink ?>