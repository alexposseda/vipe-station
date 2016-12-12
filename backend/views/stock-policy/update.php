<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model common\models\StockPolicyModel */

    $this->title = Yii::t('system/view', 'Update').' '.Yii::t('models/stock', 'Stock').' '.Yii::t('models/stock', 'Policy').': '.$model->name;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Policy'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = Yii::t('system/view', 'Update');
?>
<div class="stock-policy-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
