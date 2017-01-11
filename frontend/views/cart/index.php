<?php
/**
 * @var $this \yii\web\View
 * @var $orderModel \common\models\forms\OrderForm
 */
use common\models\CartModel;
use frontend\assets\AppAsset;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
    $this->params['headerTitle'] = 'Корзина';
$this->registerJsFile('js/cart.js', ['depends' => AppAsset::className()]);

?>
<div class="page-main valign-wrapper">
    <div class="content valign">
        <div class="cart-page">
            <div class="row move-to-checkout">
                <div class="col l5 s6 cart-your-order">
                    <div class="cart-your-order-wrap">
                        <h2 class="cart-your-order-title fs30 fc-brown">Ваш заказ</h2>
                        <?= ListView::widget([
                            'dataProvider' => new ActiveDataProvider(['query' => CartModel::getCartQuery()]),
                            'itemView' => '_cartItem',
                            'layout' => "{items}",
                            'options' => ['class' => 'products'],
                            'itemOptions' => ['class' => 'row product'],
                        ]) ?>
                        <div class="row">
                            <div class="col s12 right-align total-you-order mt-30 mb-30">
                                <span class="fs20 fc-dark-brown">
                                    Итого: <span id="total-cart-price"></span>$
                                </span>
                            </div>
                        </div>
                        <div class="col s12 hide-on-large-only center-align cart-checkout-btn">
                            <div class="btn-buy">
                                <button type="button" id="move_to_checkout1">Оформить заказ</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col l7 s6 center-align checkout">
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs fs25 fc-dark-brown ">
                                <li class="tab col s6"><a class="active" href="#new_customer">Новый покупатель</a>
                                </li>
                                <li class="tab col s6"><a href="#regular_customer">Постояный покупатель</a></li>
                            </ul>
                        </div>
                        <div id="new_customer" class="col s12">
                                <?php $orderForm = ActiveForm::begin(['class' => 'row', 'id' => 'order-form', 'action' => '/cart/create-order']) ?>
                                <div class="col s12 m6 l6">
                                    <p class="n1 title-form-new-customer fs16 fc-orange">Авторизация</p>
                                    <?= $orderForm->field($orderModel->deliveryData, 'f_name',['options'=>['class'=>'col s12']]) ?>
                                    <?= $orderForm->field($orderModel->deliveryData, 'l_name',['options'=>['class'=>'col s12']]) ?>
                                    <?= $orderForm->field($orderModel->deliveryData, 'phone',['options'=>['class'=>'col s12 input-phone-wrapper input-field']])
                                        ->textInput(['class'=>'input-phone']) ?>
                                    <?= $orderForm->field($orderModel->deliveryData, 'email',['options'=>['class'=>'col s12']]) ?>
                                </div>
                                <!--По дизайну здесь надо разделить на 2 шага для мобильной верстки-->
                                <div class="col s12 m6 l6 order-property">
                                    <p class="n2 title-form-new-customer fs16 fc-orange">Информация о доставке</p>
                                    <div class="row">

                                        <?= $orderForm->field($orderModel->deliveryData, 'city', ['options' => ['class' => 'col s12']])
                                            ->textInput(['placeholder' => 'Placeholder'])
                                            ->label($orderModel->deliveryData->getAttributeLabel('city'), ['class' => 'fs15 fc-brown']) ?>

                                        <?= $orderForm->field($orderModel->order, 'delivery_id', ['options' => ['class' => 'col s12']])
                                            ->label('Вариант доставки', ['class' => 'fs15 fc-brown'])
                                            ->dropDownList(ArrayHelper::map($orderModel->getDeliverArr(), 'id', 'name'), [
                                                'prompt' => 'Выберите вариант',
                                                'class' => 'fc-dark-brown'
                                            ]) ?>
                                        <?= $orderForm->field($orderModel->deliveryData, 'address', ['options' => ['class' => 'col s12']])
                                            ->textInput(['placeholder' => 'Placeholder'])
                                            ->label($orderModel->deliveryData->getAttributeLabel('address'), ['class' => 'fs15 fc-brown']) ?>

                                        <?= $orderForm->field($orderModel->order, 'payment_id', ['options' => ['class' => 'col s12']])
                                            ->label('Вариант оплаты', ['class' => 'fs15 fc-brown'])
                                            ->dropDownList(ArrayHelper::map($orderModel->getPayArr(), 'id', 'name'), [
                                                'prompt' => 'Выберите вариант',
                                                'class' => 'fc-dark-brown'
                                            ]) ?>
                                        <?= $orderForm->field($orderModel->order, 'comment', ['options' => ['class' => 'col s12']])
                                            ->textarea(['class' => 'materialize-textarea'])
                                            ->label('Комментарий к заказу', ['class' => 'fs15 fc-brown']) ?>

                                    </div>

                                </div>
                                <?php ActiveForm::end() ?>
                            <div class="row mb-0">
                                <div class="col s12 m6 hide-on-large-only center-align mb-15">
                                    <div class="btn-buy">
                                        <button type="submit" id="move_to_cart">В корзину</button>
                                    </div>
                                </div>
                                <div class="col s12 m6 l12 center-align">
                                    <div class="btn-buy">
                                        <button type="button" id="move_to_checkout">Оформить заказ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="regular_customer" class="col s12">
                            <div class="row">
                                <div class="col s12 center-align cart-signIn">
                                    <img src="../images/cabinet3.png" alt="">
                                </div>
                            </div>
                            <div class="col s12 center-align cabinet-form">
                                <form class="row">
                                    <div class="input-field col s12">
                                        <input placeholder="Placeholder" id="first_name" type="email"
                                               class="validate input-form">
                                        <label for="first_name" class="label-form">First Name</label>
                                    </div>
                                    <div class="input-field col s12 margin-center">
                                        <input placeholder="Placeholder" id="first_name" type="password"
                                               class="validate input-form">
                                        <label for="first_name" class="label-form">Password</label>
                                    </div>
                                    <div class="col s12 center-align">
                                        <div class="btn-buy">
                                            <button type="submit">Войти</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
