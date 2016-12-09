<?php

    /**
     * @var $this  yii\web\View
     * @var $model common\models\StockModel
     */
    use yii\helpers\Html;

    $this->title = $model->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Stocks'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-model-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('system/view', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('system/view', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('system/view', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?php foreach($model->products as $product): ?>


        <div class="panel panel-default">
            <span class="panel-heading"><?= Yii::t('models', 'Products') ?></span>
            <div class="panel-body">
                <?=$product->title?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
