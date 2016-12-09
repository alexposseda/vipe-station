<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model \backend\models\forms\StockForm */

    $this->title = Yii::t('system/view', 'Create').' '.Yii::t('models', 'Stock');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Stocks'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
