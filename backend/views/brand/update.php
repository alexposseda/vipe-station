<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BrandForm */

$this->title = Yii::t('system/view', 'Update').' '.Yii::t('models', 'Brand'). $model->brand->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->brand->title, 'url' => ['view', 'id' => $model->brand->id]];
$this->params['breadcrumbs'][] = Yii::t('system/view', 'Update');
?>
<div class="brand-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
