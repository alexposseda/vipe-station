<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\CartModel
     */

    use yii\helpers\Html;
    use yii\helpers\Url;

?>
<div class="row product">
    <div class="col s3 product-img img-wrap-you-order">
        <?= Html::a(Html::img($model->product->cover), Url::to(['/product/view', 'id' => $model->product_id]), ['class' => 'product-img']) ?>
    </div>
    <div class="col s7 product-description">
        <div class="fs18 fc-orange title mb-5">
            <a href="<?= Url::to(['/product/view', 'id' => $model->product_id]) ?>">
                <?= $model->product->title ?>
            </a>
        </div>
        <?php if(!empty($model->product->brand_id)): ?>
            <div class="fs15 fc-dark-brown brand mb-5">
                <?= $model->product->brand->title ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col s2 right-align">
        <?= Html::a('', Url::to(['delete', 'id' => $model->id]), ['class' => 'delete-product']) ?>
    </div>
    <div class="product-total col s9">
        <div class="count-yoy-order left fc-brown">
            <span><?= Yii::t('models/cart', 'Quantity') ?> </span>
            <a href="#" class="fc-brown down">-</a>
            <input id="count" value="1" type="text" data-base_quantity="<?= $model->product->base_quantity ?>"/>
            <a href="#" class="fc-brown up">+</a>
        </div>
        <div class="right price">
            <span class="fc-dark-brown fs20 all_price" data-base_price="<?= $model->price ?>">
                <?= $model->price ?>
            </span>
            <span class="fc-dark-brown fs20">
                &nbsp<?= Yii::t('models/cart', 'UAH') ?>
            </span>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="cart-border-bottom col s12"></div>
    </div>

</div>

