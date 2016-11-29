<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DeliveryModel */

$this->title = 'Create Delivery Model';
$this->params['breadcrumbs'][] = ['label' => 'Delivery Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
