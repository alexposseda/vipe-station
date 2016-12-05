<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CategoryModel */

$this->title = 'Create Category Model';
$this->params['breadcrumbs'][] = ['label' => 'Category Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
