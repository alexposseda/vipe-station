<?php
    /**
     * @var $this    \yii\web\View
     * @var $content string
     */

    use common\models\ShopSettingTable;
    use frontend\assets\AppAsset;
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Html;
    use yii\helpers\Url;

    AppAsset::register($this);

    $shopName = ShopSettingTable::getSettingValue('shopName');
    if(empty($shopName)){
        $shopName = Yii::$app->name;
    }
    $shopAddresses = ShopSettingTable::getSettingValue('address');
    $shopBaseAddress = '';
    $shopBasePhones = '';
    $shopBaseSchedule = '';

    if(!empty($shopAddresses)){
        $shopAddresses = json_decode($shopAddresses);
        foreach($shopAddresses as $s_a){
            if($s_a->isGeneral == 1){
                $shopBaseAddress = $s_a->address;
                $shopBasePhones = $s_a->phones;
                $shopBaseSchedule = $s_a->schedule;
                break;
            }
        }
    }

    $socials = ShopSettingTable::getSettingValue('social');
    if(!empty($socials)){
        $socials = json_decode($socials);
    }
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
    <?php if(Yii::$app->controller->action->id != 'index'):?>

    <nav class="top-nav static">
        <div class="container">
            <div class="nav-wrapper">
                <div class="page-header">
                    <ul class="row mb-0">
                        <?= $this->render('_header')?>
                        <li class="col l7 m12 s12 pull-l5">
                            <ul class="row mt-10 mb-0">
                                <li class="col s2 m2 l3 hide-on-large-only">
                                    <a href="#" data-activates="nav-mobile"
                                       class="button-collapse top-nav full hide-on-large-only"><i
                                                class="material-icons large">menu</i></a>
                                </li>
                                <li class="col s10 m10 l12 left-align page-title">
                                    <a href="#" class="fc-orange fs20 border-r"><?= $this->params['headerTitle']?></a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <?php endif;?>
    <div class="valign-wrapper">
        <ul id="nav-mobile" class="side-nav fixed white-text valign" style="transform: translateX(0%);">
            <?php if(Yii::$app->controller->action->id != 'index'):?>
            <a href="#" id="close-sidenav" class="hide-on-med-and-up"><img src="../images/close-round-white.svg" width="45px" alt="Закрыть"></a>
            <?php endif;?>
            <li class="logo">
                <a id="logo" href="<?= Url::to(['site/index']) ?>" class="brand-logo">
                    <img class="logo" src="<?= Url::to('/images/logo.png', true) ?>">
                </a>
            </li>
            <li class="menu">
                <ul class="col 112 nav-menu fs25 center-align">
                    <li><a href="<?= Url::to(['/site/about']) ?>">О нас</a></li>
                    <li><a href="<?= Url::to(['/catalog']) ?>">Каталог</a></li>
                    <li><a href="<?= Url::to(['/site/shipping-payment']) ?>">Доставка и оплата</a></li>
                    <li><a href="<?= Url::to(['/site/shops']) ?>">Наши магазины</a></li>
                    <li>
                        <hr>
                    </li>
                    <li class="hide-on-med-and-up">
                        <a href="#modallogin" class="modal-trigger side-nav-modal">Кабинет</a>
                    </li>
                    <li class="hide-on-med-and-up">
                        <hr>
                    </li>
                </ul>
            </li>
            <li class="address-schedule">
                <div class="row valign-wrapper mb-10">
                    <div class="col l6 m12 s12 valign left-align width">
                        <span class="fs14"><?= $shopName ?></span><br>
                        <span class="fs14"><?= $shopBaseAddress ?></span>
                    </div>
                    <div class="col l6 m12 valignleft-align width schedule">
                        <div class="fs14">
                            <?= nl2br($shopBasePhones) ?> <br><?= $shopBaseSchedule ?>
                        </div>
                    </div>
                </div>
            </li>
            <!--                <li class="subscribe">-->
            <!--                    <div class="row navbar-search">-->
            <!--                        <div class="col s12 m12 l12">-->
            <!--                            <form>-->
            <!--                                <div class="input-field">-->
            <!--                                    <input id="search" type="search" required>-->
            <!--                                    <input type="submit" alt="" class="plus" value="">-->
            <!--                                </div>-->
            <!--                            </form>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </li>-->
            <li>
                <div class="row mb-0">
                    <div class="col s12 m12 l12 center-align">
                        <?php foreach($socials as $social): ?>
                            <a href="<?= $social->link ?>" class="social-icon">
                                <img src="<?= FileManager::getInstance()
                                                         ->getStorageUrl().substr($social->icon, 1) ?>" alt="<?= $social->title ?>">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<main>
    <?= $content ?>
</main>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
