<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('system/view', 'Update').' '.Yii::t('models/user', 'User').': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models','Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system/view','Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'rol_user' => $rol_user,
    ]) ?>

</div>