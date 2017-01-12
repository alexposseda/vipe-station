<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\ProductModel
     */

    $cartForm = new \common\models\forms\CartForm();
?>
    <div class="wrap-items">
        <div class="wrap-items-first-section left center-align">
            <div class="product-img">
                <img src="<?= $model->getCover()?>" alt="<?= $model->title?>" class="">
            </div>
            <div class="wrap-text-block">
                <div class="product-title fs20 fc-orange"><?= $model->title?></div>
                <div class="product-brand fs15 fc-dark-brown"><?= $model->brand->title?></div>
                <div class="product-price fs20 fc-light-brown"><?= $model->base_price?> UAH</div>
                <!--<span class="block-bottom"></span>-->
            </div>

        </div>
        <div class="wrap-items-second-section left">
            <div class="product-title">
                <a href="<?= \yii\helpers\Url::to(['catalog/product', 'slug' => $model->slug])?>" class="fs20 fc-orange"><?= $model->title?></a></div>
            <div class="product-price">
                <span class="right fs20 fc-light-brown"><?= $model->base_price?> UAH</span>
                <div class="clearfix"></div>
            </div>


            <div class="product-description fs15 fc-dark-brown"><p><?=  nl2br($model->description)?></p></div>
            <div class="btn-buy center-align fs15 fc">
<!--                <button data-target="buyproduct">Детали</button>-->
                <a href="<?= \yii\helpers\Url::to(['catalog/product', 'slug' => $model->slug])?>">Перейти</a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>