<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PaymentModel */

$this->title = Yii::t('system/views', 'Update').' '.Yii::t('models/payment', 'Payment').': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models','Payment'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system/views','Update');
?>
<div class="payment-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
