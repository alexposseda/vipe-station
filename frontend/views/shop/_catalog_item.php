<?php
    /**
     * @var $this \yii\web\View
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Html;
    use yii\helpers\Url;

?>
<div class="wrap-items">
    <div class="wrap-items-first-section left center-align">
        <div class="product-img">
            <img src="<?= FileManager::getInstance()
                                     ->getStorageUrl().$model->cover ?>">
        </div>
        <div class="wrap-text-block">
            <div class="product-title fs20 fc-orange">
                <?= Html::encode($model->title) ?>
            </div>
            <div class="product-brand fs15 fc-dark-brown">
                <?= Html::encode($model->brand->title) ?>
            </div>
            <div class="product-price fs20 fc-light-brown">
                <?= $model->base_price.' '.Yii::t('models/cart', 'UAH') ?>
            </div>
        </div>
    </div>
    <div class="wrap-items-second-section left">
        <div class="product-title">
            <a href="<?= Url::to(['shop/product', 'id' => $model->id]) ?>"
               class="fs20 fc-orange"><?= Html::encode($model->title) ?></a>
        </div>
        <div class="product-price">
            <span class="right fs20 fc-light-brown"><?= $model->base_price.' '.Yii::t('models/cart', 'UAH') ?></span>
            <div class="clearfix"></div>
        </div>
        <div class="product-description fs15 fc-dark-brown">
            <p><?= Html::encode($model->description) ?></p>
        </div>
        <div class="btn-buy center-align fs15 fc">
            <button data-target="buyproduct" class="modal-trigger">Купить</button>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
