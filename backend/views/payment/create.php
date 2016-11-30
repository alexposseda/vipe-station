<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PaymentModel */

$this->title = Yii::t('system/views', 'Create').' '.Yii::t('models/payment', 'Payment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Payment'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
