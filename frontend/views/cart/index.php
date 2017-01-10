<?php
/**
 * @var $this \yii\web\View
 */
use common\models\CartModel;
use frontend\assets\AppAsset;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

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
                            'layout'       => "{items}",
                            'options' => ['class' => 'products'],
                            'itemOptions'  => ['class' => 'row product'],
                        ]) ?>
                        <div class="row">
                            <div class="col s12 right-align total-you-order mt-30 mb-30">
                                <span class="fs20 fc-dark-brown">
                                    Итого: 17$
                                </span>
                            </div>
                        </div>
                        <div class="col s12 hide-on-large-only center-align cart-checkout-btn">
                            <div class="btn-buy">
                                <button type="submit" id="move_to_checkout">Оформить заказ</button>
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
                            <div class="row">
                                <div class="col s12 m6 l6">
                                    <p class="n1 title-form-new-customer fs16 fc-orange">Авторизация</p>
                                    <form class="row">
                                        <div class="input-field col s12">
                                            <input placeholder="Placeholder" type="text"
                                                   class="validate input-form">
                                            <label for="first_name" class="label-form">Имя</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input placeholder="Placeholder" type="text"
                                                   class="validate input-form">
                                            <label for="first_name" class="label-form">Фамилия</label>
                                        </div>
                                        <div class="input-field col s12 input-phone-wrapper">
                                            <input placeholder="Placeholder" type="text"
                                                   class="validate input-form input-phone">
                                            <label for="first_name" class="label-form">Телефон</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input placeholder="Placeholder" type="text"
                                                   class="validate input-form">
                                            <label for="first_name" class="label-form">Email</label>
                                        </div>
                                    </form>
                                </div>
                                <!--По дизайну здесь надо разделить на 2 шага для мобильной верстки-->
                                <div class="col s12 m6 l6">
                                    <p class="n2 title-form-new-customer fs16 fc-orange">Информация о доставке</p>
                                    <form action="" class="row">
                                        <div class="input-field col s12">
                                            <input placeholder="Placeholder" type="text"
                                                   class="validate input-form">
                                            <label for="first_name" class="label-form">Город</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <select class="fc-dark-brown">
                                                <option value="" disabled selected>Выберите вариант</option>
                                                <option value="1">Option 1</option>
                                                <option value="2">Option 2</option>
                                                <option value="3">Option 3</option>
                                            </select>
                                            <label class="label-form">Вариант доставки</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input placeholder="Placeholder" type="text"
                                                   class="validate input-form">
                                            <label for="first_name" class="label-form">Адрес</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <select>
                                                <option value="" disabled selected>Выберите вариант</option>
                                                <option value="1">Option 1</option>
                                                <option value="2">Option 2</option>
                                                <option value="3">Option 3</option>
                                            </select>
                                            <label class="label-form">Варинат оплаты</label>
                                        </div>
                                        <div class="col s12">
                                            <label for="textarea1" class="fs15 fc-brown">Комментарий к
                                                заказу</label>
                                            <textarea id="textarea1" class="materialize-textarea"
                                                      length="120"></textarea>
                                        </div>
                                    </form>


                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col s12 m6 hide-on-large-only center-align mb-15">
                                    <div class="btn-buy">
                                        <button type="submit" id="move_to_cart">В корзину</button>
                                    </div>
                                </div>
                                <div class="col s12 m6 l12 center-align">
                                    <div class="btn-buy">
                                        <button type="submit">Оформить заказ</button>
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
