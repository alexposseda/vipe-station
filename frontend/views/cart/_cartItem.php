<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\CartModel
 */
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="col s3 product-img img-wrap-you-order">
    <img src="<?= $model->product->cover ?>" alt="">
</div>
<div class="col s9">
    <div class="row">
        <div class="col s10 product-description">
            <div class="fs18 fc-orange title mb-5"><?= $model->product->title ?>
            </div>
            <div class="fs15 fc-dark-brown brand mb-5"><?= $model->product->brand->title ?></div>
        </div>
        <div class="col s2 right-align">
            <?= Html::button('', [
                'data-url' => Url::to(['delete', 'id' => $model->id]),
                'class' => 'delete-product'
            ]) ?>
        </div>
        <div class="product-total col s12">
            <div class="count-yoy-order left fc-brown"
                 data-url="<?=Url::to(['cart/add-to-cart', 'product_id'=>$model->product_id])?>">
                <span>Кол-во: </span>
                <span class="quantity-btn fc-brown" data-action="minus">-</span>
                <input class="count" type="text" readonly value="<?= $model->quantity ?>">
                <span class="quantity-btn fc-brown" data-action="plus">+</span>
            </div>
            <div class="right price">
                <span class="fc-dark-brown fs20">17$</span>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="cart-border-bottom col s12"></div>
</div>
