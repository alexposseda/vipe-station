<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryModel */

$this->title = Yii::t('system/view', 'Update').' '.Yii::t('models/category','Category').': '. $model->category->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category->title, 'url' => ['view', 'id' => $model->category->id]];
$this->params['breadcrumbs'][] = Yii::t('system/view', 'Update');
?>
<div class="category-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
