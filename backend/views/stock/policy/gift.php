<?php
    /**
     * @var $model        \common\models\StockModel
     * @var $all_products \common\models\ProductModel[]
     * @var $stock_value  []
     */
    use yii\bootstrap\Html;
    use yii\helpers\ArrayHelper;

?>
<?= Html::activeHiddenInput($model, 'stock_value') ?>
<div class="form-group">
    <p><?= Yii::t('models/stock', 'Gift product') ?></p>
    <?= Html::dropDownList('products', $stock_value->gift, ArrayHelper::map($all_products, 'id', 'title'),
                           ['prompt' => Yii::t('system/view', 'Select').' '.Yii::t('models/stock', 'Gift product'),
                           'id'=>'products-gift']) ?>
</div>