<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ManufacturerModel */

$this->title = 'Update Manufacturer Model: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Manufacturer Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="manufacturer-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
