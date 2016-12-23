<?php
    /**
     * @var $this             \yii\web\View
     * @var $dataProvider     \yii\data\ActiveDataProvider
     */

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ListView;

?>
<div class="page-main valign-wrapper">
    <div class="content valign">
        <div class="row cart-page">
            <div class="col l5 hide-on-med-and-down cart-your-order">
                <?php if($dataProvider->count > 0): ?>
                    <div class="cart-your-order-wrap">
                        <h2 class="cart-your-order-title fs30 fc-brown"><?= Yii::t('models/cart', 'Your order') ?></h2>
                        <?= ListView::widget([
                                                 'dataProvider' => $dataProvider,
                                                 'itemView'     => '_itemCart'
                                             ]) ?>
                        <div class="col l12 right-align total-you-order">
                            <span class="fs20 fc-dark-brown"><?= Yii::t('models/cart', 'Total Price') ?> </span>
                            <span id="total-price" class="fs20 fc-dark-brown"></span>
                            <span class="fs20 fc-dark-brown"><?= Yii::t('models/cart', 'UAH') ?></span>
                        </div>
                    </div>

                <?php else: ?>
                    <h2 class="cart-your-order-title fs30 fc-brown"><?= Yii::t('models/cart', 'Cart is empty') ?></h2>
                <?php endif; ?>
            </div>

            <div class="col l7 center-align">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs fs25 fc-dark-brown ">
                            <li class="tab col s6"><a class="active" href="#test1">Новый покупатель</a></li>
                            <li class="tab col s6"><a href="#test2">Постояный покупатель</a></li>
                        </ul>
                    </div>
                    <div id="test1" class="col s12">
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <p class="n1 title-form-new-customer fs20 fc-orange">Авторизация</p>
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
                                    <div class="input-field col s12">
                                        <input placeholder="Placeholder" type="text"
                                               class="validate input-form">
                                        <label for="first_name" class="label-form">Телефон</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input placeholder="Placeholder" type="text"
                                               class="validate input-form">
                                        <label for="first_name" class="label-form">Email</label>
                                    </div>
                                </form>
                            </div>
                            <div class="col s12 m6 l6">
                                <p class="n2 title-form-new-customer fs20 fc-orange">Информация о доставке</p>
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
                                        <label for="textarea1" class="fs20 fc-brown">Комментарий к заказу</label>
                                        <textarea id="textarea1" class="materialize-textarea" length="120"></textarea>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                    <div id="test2" class="col s12">
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
