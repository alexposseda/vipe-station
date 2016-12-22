<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\BrandModel
     */

    use yii\helpers\Html;
    use yii\helpers\Url;

?>
<div class="wrap-items">
    <div class="wrap-items-first-section left center-align">
        <div class="product-img">
            <img src="<?= $model->logo ?>">
        </div>
        <div class="wrap-text-block">
            <div class="product-title fs20 fc-orange">
                <?= Html::encode($model->title) ?>
            </div>
        </div>
    </div>
    <div class="wrap-items-second-section left">
        <div class="product-title">
            <a href="<?= Url::to(['shop/product', 'id' => $model->id]) ?>"
               class="fs20 fc-orange"><?= Html::encode($model->title) ?></a>
        </div>
        <div class="product-description fs15 fc-dark-brown">
            <p><?= Html::encode($model->description) ?></p>
        </div>
        <div class="btn-buy center-align fs15 fc">
            <a href="<?= Url::to(['shop/catalog-all', 'ProductSearchModel[brand_id]' => $model->id]) ?>">Перейти</a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
