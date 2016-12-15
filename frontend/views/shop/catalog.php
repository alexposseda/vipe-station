<?php
/**
 * @var $this \yii\web\View
 */
    use frontend\assets\CatalogAsset;
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Html;
    use yii\helpers\Url;

    CatalogAsset::register($this);
?>

<div class="col s12 page-main">
    <div class="sub-title">
        <a href="#" class="fs30 white-text title-catalog"><?=Yii::t('models/product','Popular goods')?></a>
    </div>
    <div class="content">
        <div class="catalog-background">
            <div class="catalog-wrap-content product-carousel">
                <?php foreach($popular as $product): ?>
                <div class="wrap-overflow product">
                    <div class="wrap-items">
                        <div class="wrap-items-first-section left center-align">
                            <div class="product-img">
                                <img src="<?= FileManager::getInstance()
                                                         ->getStorageUrl().$product->cover ?>">
                            </div>
                            <div class="wrap-text-block">
                                <div class="product-title fs20 fc-orange"><?= Html::encode($product->title) ?></div>
                                <div class="product-brand fs15 fc-dark-brown"><?= Html::encode($product->brand->title) ?></div>
                                <div class="product-price fs20 fc-light-brown"><?= $product->base_price.' '.Yii::t('models/product', 'UAH') ?></div>
                            </div>

                        </div>
                        <div class="wrap-items-second-section left">
                            <div class="product-title">
                                <a href="<?= Url::to(['shop/product', 'id' => $product->id]) ?>"
                                   class="fs20 fc-orange"><?= Html::encode($product->title) ?></a></div>
                            <div class="product-price">
                                <span class="right fs20 fc-light-brown"><?= $product->base_price.' '.Yii::t('models/product', 'UAH') ?></span>
                                <div class="clearfix"></div>
                            </div>

                            <div class="product-description fs15 fc-dark-brown"><p><?= Html::encode($product->description) ?></p></div>
                            <div class="btn-buy center-align fs15 fc">
                                <button data-target="buyproduct" class="modal-trigger"><?=Yii::t('models/product','Buy')?></button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="sub-title">
        <a href="#" class="fs30 white-text title-catalog"><?=Yii::t('models/product','New goods')?></a>
    </div>
    <div class="content">

        <div class="catalog-background">
            <div class="catalog-wrap-content brand-carousel">
                <?php foreach($newest as $product): ?>
                <div class="wrap-overflow brand">
                    <div class="wrap-items">
                        <div class="wrap-items-first-section left center-align">
                            <div class="product-img">
                                <img src="<?= FileManager::getInstance()
                                                         ->getStorageUrl().$product->cover ?>">
                            </div>
                            <div class="wrap-text-block">
                                <div class="product-title fs20 fc-orange"><?= Html::encode($product->title) ?></div>
                                <div class="product-brand fs15 fc-dark-brown"><?= Html::encode($product->brand->title) ?></div>
                                <div class="product-price fs20 fc-light-brown"><?= $product->base_price.' '.Yii::t('models/cart', 'UAH') ?></div>
                            </div>

                        </div>
                        <div class="wrap-items-second-section left">
                            <div class="product-title">
                                <a href="<?= Url::to(['shop/product', 'id' => $product->id]) ?>"
                                   class="fs20 fc-orange"><?= Html::encode($product->title) ?></a></div>
                            <div class="product-price">
                                <span class="right fs20 fc-light-brown"><?= $product->base_price.' '.Yii::t('models/cart', 'UAH') ?></span>
                                <div class="clearfix"></div>
                            </div>

                            <div class="product-description fs15 fc-dark-brown"><p><?= Html::encode($product->description) ?></p></div>
                            <div class="btn-buy center-align fs15 fc">
                                <button data-target="buyproduct" class="modal-trigger"><?=Yii::t('models/product','Buy')?></button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
