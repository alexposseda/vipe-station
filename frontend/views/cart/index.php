<?php
?>


<div class="page-main valign-wrapper">
    <div class="content valign">
        <div class="row cart-page">
            <div class="col l5 hide-on-med-and-down cart-your-order">
                <div class="cart-your-order-wrap">
                    <h2 class="cart-your-order-title fs30 fc-brown">Ваш заказ</h2>
                    <div class="row product">
                        <div class="col s3 product-img img-wrap-you-order">
                            <img src="../images/catalog1.png" alt="">
                        </div>
                        <div class="col s7 product-description">
                            <div class="fs18 fc-orange title mb-5">Найменование
                            </div>
                            <div class="fs15 fc-dark-brown brand mb-5">Бренд</div>
                        </div>
                        <div class="col s2 right-align">
                            <button class="delete-product"></button>
                        </div>
                        <div class="product-total col s9">
                            <div class="count-yoy-order left fc-brown">
                                <span>Кол-во: </span>
                                <a id="down" href="#" onclick="updateSpinner(this);" class="fc-brown">-</a>
                                <input id="count" value="1" type="text"/>
                                <a id="up" href="#" onclick="updateSpinner(this);" class="fc-brown">+</a>
                            </div>
                            <div class="right price">
                                <span class="fc-dark-brown fs20">17$</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="cart-border-bottom col s12"></div>
                        </div>
                    </div>

                    <div class="col l12 right-align total-you-order">
                                <span class="fs20 fc-dark-brown">
Итого 17 $
                                </span>
                    </div>
                </div>
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
