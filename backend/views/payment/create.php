<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PaymentModel */

$this->title = 'Create Payment Model';
$this->params['breadcrumbs'][] = ['label' => 'Payment Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
