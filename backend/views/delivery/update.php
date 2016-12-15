<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DeliveryModel */

$this->title = Yii::t('system/view', 'Update').' '.Yii::t('models/delivery', 'Delivery').': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Delivery'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system/view', 'Update');
?>
<div class="delivery-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
