<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StockPolicyModel */

$this->title =  Yii::t('system/view', 'Create').' '.Yii::t('models', 'Stock').' '.Yii::t('models', 'Policy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Policy'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-policy-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
