<?php
    /**
     * @var $model \common\models\StockModel
     */
    use yii\bootstrap\Html;
?>
<div class="form-group">
    <?= Html::label(Yii::t('models/stock', 'Discount value'), 'discount_value', ['class' => 'control-label']) ?>
    <?= Html::activeInput('number', $model, 'stock_value', ['id' => 'discount_value']) ?>
</div>