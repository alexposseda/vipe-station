<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\ProductModel
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
        <div class="btn-buy center-align fs15 fc">
            <?= Html::a('Купить', ['cart/add-to-cart', 'product_id' => $model->id, 'options' => '{[de:de]}', 'quantity' => 1],
                        ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
