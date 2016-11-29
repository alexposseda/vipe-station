<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BrandModel */

$this->title = 'Create Brand Model';
$this->params['breadcrumbs'][] = ['label' => 'Brand Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
