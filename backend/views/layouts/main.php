<?php

    /* @var $this \yii\web\View */
    /* @var $content string */

    use backend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\widgets\Breadcrumbs;
    use common\widgets\Alert;

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

<div class="wrap">
    <?php
        NavBar::begin([
                          'brandLabel' => Yii::$app->name,
                          'brandUrl'   => Yii::$app->homeUrl,
                          'options'    => [
                              'class' => 'navbar-inverse navbar-fixed-top',
                          ],
                      ]);

        if(Yii::$app->user->isGuest){
            $menuItems[] = [
                'label' => Yii::t('system/view', 'Login'),
                'url'   => ['/site/login']
            ];
        }else{
            $menuItems = [
                [
                    'label' => Yii::t('system/view', 'DashBoard'),
                    'url'   => ['/site/index']
                ],
                [
                    'label' => Yii::t('system/view', 'Catalog'),
                    'url'   => ['/catalog/index']
                ],
                [
                    'label' => Yii::t('system/view', 'Orders'),
                    'url'   => ['/order/index']
                ],
                [
                    'label' => Yii::t('system/view', 'Clients'),
                    'url'   => ['/client/index']
                ],
                [
                    'label' => Yii::t('system/view', 'Shop Setting'),
                    'items' => [
                        [
                            'label' => Yii::t('system/view', 'General Setting'),
                            'url'   => ['setting-shop/index']
                        ],
                        [
                            'label' => Yii::t('system/view', 'Address Setting'),
                            'url'   => ['setting-shop/address-setting']
                        ],
                        [
                            'label' => Yii::t('system/view', 'Delivery and Payment'),
                            'url'   => ['setting-shop/deliver-pay']
                        ],
                        [
                            'label' => Yii::t('system/view', 'Users'),
                            'url'   => ['/user/index']
                        ],
                        [
                            'label' => Yii::t('system/view', 'Delivery'),
                            'url'   => ['delivery/index']
                        ],
                        [
                            'label' => Yii::t('system/view', 'Payment'),
                            'url'   => ['payment/index']
                        ],
                        [
                            'label' => Yii::t('system/view', 'Brands'),
                            'url'   => ['brand/index']
                        ],
                        [
                            'label' => Yii::t('system/view', 'SEO'),
                            'url'   => ['seo/index']
                        ],
                        [
                            'label' => Yii::t('system/view', 'Categories'),
                            'url'   => ['category/index']
                        ],
                        [
                            'label' => Yii::t('system/view', 'Products'),
                            'url'   => ['product/index']
                        ],
                        [
                            'label' => Yii::t('system/view', 'Log'),
                            'url'   => ['site/index-log']
                        ]
                    ]
                ],
                [
                    'label' => Yii::t('system/view', 'Cabinet'),
                    'url'   => ['/personal/index']
                ]
            ];
            $menuItems[] = '<li>'.Html::beginForm(['/site/logout'], 'post').Html::submitButton(Yii::t('system/view', 'Logout'),
                                                                                               ['class' => 'btn btn-link logout']).Html::endForm().'</li>';
        }
        echo Nav::widget([
                             'options' => ['class' => 'navbar-nav navbar-right'],
                             'items'   => $menuItems,
                         ]);
        NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; GR.Solutions <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
