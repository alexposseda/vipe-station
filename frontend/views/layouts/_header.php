<?php
?>
<li class="col l5 m12 s12 push-l7 valign">
    <ul class="row valign-wrapper mt-25">
        <li class="col l7 push-m6 m6 push-s3 s9 header-second-section input-search search-left valign">
            <div class="nav-wrapper">
                <form>
                    <div class="input-field ">
                        <input id="search" type="search" required
                               class="search-header-input input-left">
                        <button data-target="modalsearch" type="submit"
                                class="modal-trigger material-icons do-search">search
                        </button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <!--активный поиск :start-->
            <div id="modalsearch"
                 class="modal bottom-sheet popup popup-active popup-search popup-bottom">
                <div class="popup-content modal-content">
                    <div class="row product valign-wrapper">
                        <div class="col s4 m3 l3 product-img-wrapper">
                            <a href="" class="product-img">
                                <img src="../images/catalog1.png" alt="" class="">
                            </a>
                        </div>
                        <div class="col s8 m6 l6">
                            <div class="active-cart-name left-align">
                                <a href=""><span class="fs20 fc-orange">Найменование</span></a>
                                <a href=""><span class="fs15 fc-light-brown">52.70$</span></a>
                            </div>
                        </div>
                        <div class="col s12 m3 l3 right-align">
                            <div class="btn-active-search-buy btn-buy fc-brown">
                                <button type="submit">Купить</button>
                            </div>
                        </div>
                    </div>
                    <div class="row product valign-wrapper">
                        <div class="col s4 m3 l3 product-img-wrapper">
                            <a href="" class="product-img">
                                <img src="../images/catalog1.png" alt="" class="">
                            </a>
                        </div>
                        <div class="col s8 m6 l6">
                            <div class="active-cart-name left-align">
                                <a href=""><span class="fs20 fc-orange">Найменование</span></a>
                                <a href=""><span class="fs15 fc-light-brown">52.70$</span></a>
                            </div>
                        </div>
                        <div class="col s12 m3 l3 right-align">
                            <div class="btn-active-search-buy btn-buy fc-brown">
                                <button type="submit">Купить</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <!--активный поиск :end-->

        </li>
        <li class="col l5 pull-m6 m6 pull-s9 s3 header-third-section valign left-align">
            <div class="cart-login">
                <div class="cart">

                </div>
                <div class="login border-l">
                    <a id="insert-cabinet" class="modal-trigger popup-trigger hide-on-small-and-down" href="#modallogin">
                        <span class="white-text fs15">Кабинет</span>
                    </a>
                    <div id="modallogin" class="modal popup popup-active center-align remind-pass popup-form">
                        <div class="modal-content">
                            <div class="center-align remind-pass popup-form hide-on-med-and-down" id="loginbox">
                                <form class="row cabinet-form">
                                    <div class="input-field col s12">
                                        <label for="email"
                                               class="fs15 fc-brown left-align">Email</label>
                                        <div class="input-gradient">
                                            <input placeholder="Placeholder" id="email" required
                                                   type="text"
                                                   class="validate input-form"
                                                   onFocus="$(this).parent().addClass('focus')"
                                                   onBlur="$(this).parent().removeClass('focus')">
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <label for="password" class="fs15 fc-brown left">Пароль</label>
                                        <a href="#remindpassbox" id="remindPassBtn" class="fs12 fc-dark-brown right">Забыли пароль?</a>
                                        <div class="clear"></div>
                                        <div class="input-gradient">
                                            <input placeholder="Placeholder" id="password"
                                                   type="password"
                                                   class="validate input-form"
                                                   onFocus="$(this).parent().addClass('focus')"
                                                   onBlur="$(this).parent().removeClass('focus')">
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="col s12">
                                            <button type="submit" class="dash fs25 fc-dark-brown">
                                                Войти
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="center-align remind-pass popup-form hide-on-med-and-down hide" id="remindpassbox">
                                <form class="row cabinet-form">
                                    <div class="input-field col s12">
                                        <label for="first_name" class="fs15 fc-brown">Email</label>
                                        <div class="input-gradient">
                                            <input placeholder="Placeholder" id="first_name"
                                                   type="email"
                                                   class="validate input-form"
                                                   onFocus="$(this).parent().addClass('focus')"
                                                   onBlur="$(this).parent().removeClass('focus')">
                                        </div>
                                        <a href="#loginbox" id="loginBtn" class="fs10 col s12 fc-brown">Вспомнили?</a>
                                        <div class="col s12">
                                            <button type="submit" class="dash fs25 fc-dark-brown">
                                                Напомнить
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </li>
    </ul>
</li>
