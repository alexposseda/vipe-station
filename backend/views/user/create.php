<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('system/view', 'Create').' '.Yii::t('models/user', 'User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models','Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'rol_user' => $rol_user,

    ]) ?>

</div>