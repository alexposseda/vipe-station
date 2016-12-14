<?php
    /**
     * @var $this \yii\web\View
     */
    use common\models\CartModel;
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Html;

    $cart = CartModel::getCart()
?>
<?php if($cart): ?>
    <a href="#modalcart" class="modal-trigger popup-trigger"><span
                class="white-text total-price "><?= count($cart) ?></span></a>
    <div id="modalcart"
         class="modal bottom-sheet modal-fixed-footer popup popup-active popup-cart popup-bottom popup-fixed-footer">
        <div class="popup-content modal-content">
            <?php /** @var CartModel[] $cart */
                foreach($cart as $cart_item): ?>
                    <div class="row product valign-wrapper">
                        <div class="col s3 m3 l3 product-img-wrapper">
                            <a href="" class="product-img">
                                <img src="<?= FileManager::getInstance()
                                                         ->getStorageUrl().$cart_item->product->cover ?>"
                                     alt="" class="">
                            </a>
                        </div>
                        <div class="col s7 m7 l7">
                            <div class="active-cart-name left-align">
                                <a href=""><span
                                            class="fs20 fc-orange"><?= $cart_item->product->title ?></span></a>
                                <a href=""><span
                                            class="fs15 fc-light-brown"><?= $cart_item->getPrice().' '.Yii::t('models/cart', 'UAH') ?></span></a>
                                <a href=""><span
                                            class="fs11 black-text"><?= $cart_item->quantity.' '.Yii::t('models/cart', 'pc') ?></span></a>
                            </div>
                        </div>
                        <div class="col s2 m2 l2 right-align">
                            <?= Html::a('', ['cart/remove', 'id' => $cart_item->id], ['class' => 'delete-product']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <div>
                <div class="col s12 m12 l12">
                    <div class="total-price right ">
                        <span class="fs15 fc-brown">Итого</span>
                        <span class="fs15 fc-orange">52.52</span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

        </div>
        <div class="modal-footer popup-footer">
            <!--<div class="row">-->
            <div class="col s6 m6 l6 center-align">
                <div class="btn-active-cart btn-active-cart-first btn-buy center-align fs15 fc-light-brown">
                    <a href="#" class="fc-light-brown">Оформить заказ</a>
                </div>

            </div>
            <div class="col s6 m6 l6 center-align">
                <div class="btn-active-cart btn-active-cart-second btn-buy center-align fs15 fc-light-brown">
                    <a href="#" class="fc-light-brown">В корзину</a>
                </div>
            </div>
            <!--</div>-->
        </div>
    </div>
<?php else: ?>
    <a class="popup-trigger">
        <span
                class="white-text total-price "><?= count($cart) ?></span>
    </a>
<?php endif; ?>
