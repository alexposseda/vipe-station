<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model \backend\models\forms\StockForm */

    $this->title = Yii::t('system/view', 'Update').' '.Yii::t('models/stock', 'Stock').': '.$model->stock->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Stocks'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->stock->title, 'url' => ['view', 'id' => $model->stock->id]];
    $this->params['breadcrumbs'][] = Yii::t('system/view', 'Update');
?>
<div class="product-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'  => $model,
    ]) ?>

</div>
