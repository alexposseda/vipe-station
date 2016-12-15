<?php

    /* @var $this \yii\web\View */
    /* @var $content string */

    use common\models\ShopSettingTable;
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use frontend\assets\AppAsset;

    AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header>
    <nav class="top-nav static">
        <div class="container">
            <div class="nav-wrapper">
                <div class="page-header">
                    <ul class="row">
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
                                            <?=$this->render('cart')?>
                                        </div>
                                        <div class="login border-l">
                                            <a id="insert-cabinet" class="modal-trigger popup-trigger hide-on-small-and-down" href="#modallogin">
                                                <span class="white-text fs15">Кабинет</span>
                                            </a>
                                            <div id="modallogin" class="modal popup popup-active center-align remind-pass popup-form">
                                                <div class="modal-content">
                                                    <form class="row cabinet-form">
                                                        <div class="input-field col s12">
                                                            <label for="login_email" class="fs15 fc-brown">Email</label>
                                                            <div class="input-gradient">
                                                                <input placeholder="Placeholder" id="login_email"
                                                                       type="email"
                                                                       class="validate input-form"
                                                                       onFocus="$(this).parent().addClass('focus')"
                                                                       onBlur="$(this).parent().removeClass('focus')">
                                                            </div>
                                                            <a href="#" class="fs10 col s12 fc-brown">Вспомнили?</a>
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

                                            <div class="center-align remind-pass popup-form hide-on-med-and-down hide">
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
                                                        <a href="#" class="fs12 fc-dark-brown right">Забыли пароль?</a>
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

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="col l7 m12 s12 pull-l5 valign">
                            <ul class="row mt-10">
                                <li class="col s2 m2 l3 hide-on-large-only">
                                    <a href="#" data-activates="nav-mobile"
                                       class="button-collapse top-nav full hide-on-large-only"><i
                                                class="material-icons large">menu</i></a>
                                </li>
                                <li class="col s10 m10 l12 left-align page-title">
                                    <a href="<?= Url::to(['site/shipping-payment']) ?>" class="fc-orange fs20"><?= Yii::t('shop/setting',
                                                                                                                          'Shipping and payment') ?></a>
                                    <a href="<?= Url::home() ?>" class="border-l back hide-on-small-and-down"><span
                                                class="white-text fs15"><?= Yii::t('shop/setting', 'In Shop') ?></span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="valign-wrapper">

        <ul id="nav-mobile" class="side-nav fixed white-text valign" style="transform: translateX(0%);">
            <a href="#" id="close-sidenav" class="hide-on-med-and-up"><img src="../images/close-round-white.svg" width="45px" alt="Закрыть"></a>
            <li class="logo">
                <a id="logo" href="<?= Url::home() ?>" class="brand-logo">
                    <img class="logo" src="../images/logo.png">
                </a>
            </li>
            <li class="menu">
                <ul class="col 112 nav-menu fs25 center-align">
                    <li><a href="<?= Url::to(['site/about']) ?>"><?= Yii::t('shop/setting', 'About as') ?></a></li>
                    <li><a href="<?= Url::to(['shop/catalog']) ?>"><?= Yii::t('system/view', 'Catalog') ?></a></li>
                    <li><a href="<?= Url::to(['site/shipping-payment']) ?>"><?= Yii::t('shop/setting', 'Shipping and payment') ?></a></li>
                    <li><a href="<?= Url::to(['site/shops']) ?>"><?= Yii::t('shop/setting', 'All Shop`s') ?></a></li>
                    <li>
                        <hr>
                    </li>
                    <li class="hide-on-med-and-up">
                        <a href="#modallogin" class="modal-trigger side-nav-modal"><?= Yii::t('system/view', 'Cabinet') ?></a>
                    </li>
                    <li class="hide-on-med-and-up">
                        <hr>
                    </li>

                </ul>
            </li>
            <li class="address-schedule">
                <div class="row valign-wrapper">
                    <div class="col l6 m12 s12 valign left-align width">
                        <span class="fs14">Vipe Station <br>New Yor, Balley Sreet</span>
                    </div>
                    <div class="col l6 m12 valignleft-align width schedule">
                        <div class="fs14">
                            +3805686123 <br>С 12.00 до 20.00
                        </div>
                    </div>
                </div>
            </li>
            <li class="subscribe">
                <div class="row navbar-search">
                    <div class="col s12 m12 l12">
                        <form>
                            <div class="input-field">
                                <input id="search" type="search" required>
                                <input type="submit" alt="" class="plus" value="">
                            </div>
                        </form>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <?=$this->render('social')?>
                </div><!--Social Link-->
            </li>
        </ul>
    </div>
</header>
<main class="">
    <?= $content ?>
</main>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
