<?php
    /**
     * @var $this    \yii\web\View
     * @var $content string
     */

    use common\models\BrandModel;
    use common\models\CategoryModel;
    use common\models\search\ProductSearchModel;
    use common\models\ShopSettingTable;
    use frontend\assets\AppAsset;
    use yii\alexposseda\fileManager\FileManager;
    use yii\caching\DbDependency;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;

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

    $product_search = new ProductSearchModel();
    $allCategory = CategoryModel::getDb()
                                ->cache(function(){
                                    return CategoryModel::find()
                                                        ->all();
                                }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM'.CategoryModel::tableName()]));

    $allBrand = BrandModel::getDb()
                          ->cache(function(){
                              return BrandModel::find()
                                               ->all();
                          }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM'.BrandModel::tableName()]));
    $allBrandMap = ArrayHelper::map($allBrand, 'id', 'title');

    $price = (new \yii\db\Query())->select(['MIN(base_price) as min, MAX(base_price) as max'])->from(\common\models\ProductModel::tableName())->one();
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
                    <ul class="row mb-0">
                        <li class="col l7 m12 s12 valign">
                            <?php //todo сделать проверку где представление равно catalogAll?>
                            <ul class="row">
                                <li class="col s2 m2 l3 hide-on-large-only">
                                    <a href="#" data-activates="nav-mobile"
                                       class="button-collapse top-nav full hide-on-large-only"><i
                                                class="material-icons large">menu</i></a>
                                </li>
                                <?php $search = ActiveForm::begin([
                                                                      'id'     => 'catalog-search',
                                                                      'method' => 'get'
                                                                  ]) ?>
                                <li class="col s4 m4 l3">
                                    <div class="border-r left-align">
                                        <?php foreach($allCategory as $category): ?>
                                            <?php /** @var CategoryModel $category */ ?>
                                            <?= Html::a($category->title, [
                                                'catalog/category/',
                                                'categoryName' => $category->title
                                            ], [
                                                            'class'     => 'white-text fs15',
                                                            'data-pjax' => 0
                                                        ]) ?>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                                <li class="col s6 m6 l4">
                                    <span class="white-text title-range">Цена</span>
                                    <?= $search->field($product_search, 'price')
                                               ->label(false)
                                               ->textInput(['id' => 'range-filter', 'data-min'=>$price['min'], 'data-max' => $price['max']]) ?>
                                </li>
                                <li class="col s4 l5 radio-form-catalog hide-on-med-and-down">
                                    <div class="input-field col s12">
                                        <label>Бренд</label>
                                        <?php //todo сделать так что бы при выборе бренда переходило по ссылке /catalog/brand/имя бренда ?>
                                        <?= Html::activeDropDownList($product_search, 'brand_id', $allBrandMap, ['prompt' => 'Выберите бренд']) ?>
                                    </div>
                                </li>
                            </ul>
                            <?php ActiveForm::end() ?>
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

