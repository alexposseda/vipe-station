<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ManufacturerModel */

$this->title = 'Create Manufacturer Model';
$this->params['breadcrumbs'][] = ['label' => 'Manufacturer Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturer-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
