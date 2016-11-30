<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ClientModel */

$this->title = 'Create Client Model';
$this->params['breadcrumbs'][] = ['label' => 'Client Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
