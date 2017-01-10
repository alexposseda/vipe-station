<?php
    /**
     * @var $this            \yii\web\View
     * @var $productProvider \yii\data\ActiveDataProvider
     * @var $categories      \common\models\CategoryModel[]
     * @var $brands          \common\models\BrandModel[]
     * @var $currentCategory null|\common\models\CategoryModel
     * @var $currentBrand    null|\common\models\BrandModel
     * @var $searchProduct   \common\models\search\ProductSearchModel
     */
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;
    use yii\helpers\Url;
    use yii\widgets\ListView;

?>
<div class="row">
    <div class="col-sm-12 col-md-4 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="panel-title">Быстрый поиск</p>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                                                    'method' => 'get'
                                                ]) ?>
                <?= $form->field($searchProduct, 'id')
                         ->label('Код товара') ?>
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-sm btn-success pull-right']) ?>
                <div class="clearfix"></div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
        <div class="panel-group" id="list">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-9 col-md-10 col-lg-10">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#list" href="#categories">Категории</a>
                            </p>
                        </div>
                        <div class="col-sm-3 col-md-2 col-lg-2 text-right">
                            <a href="<?= Url::to(['category/create']) ?>" class="btn btn-sm btn-success pull-right">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="categories" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="list-group">
                            <?php foreach($categories as $category): ?>
                                <a href="<?= Url::current(['ProductSearchModel[category_id]' => $category->id]) ?>"
                                   class="list-group-item <?= (Yii::$app->request->get('ProductSearchModel')['category_id'] == $category->id) ? 'active' : '' ?>"><?= $category->title ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-9 col-md-10 col-lg-10">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#list" href="#brands">Бренды</a>
                            </p>
                        </div>
                        <div class="col-sm-3 col-md-2 col-lg-2 text-right">
                            <a href="<?= Url::to(['brand/create']) ?>" class="btn btn-sm btn-success pull-right">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="brands" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="list-group">
                            <?php foreach($brands as $brand): ?>
                                <a href="<?= Url::current(['ProductSearchModel[brand_id]' => $brand->id]) ?>"
                                   class="list-group-item <?= (Yii::$app->request->get('ProductSearchModel')['brand_id'] == $brand->id) ? 'active' : '' ?>"><?= $brand->title ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "btn btn-primary">
                <a href="<?= Url::to(['cart/index']) ?>" class="btn btn-sm btn-success pull-right">
                    Перейти в корзину
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8 col-lg-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a href="<?= Url::to(['product/create']) ?>" class="btn btn-sm btn-success pull-right">
                    Добавить продукт <span class="glyphicon glyphicon-plus"></span>
                </a>
                <p class="panel-title"><?= Yii::t('models/product', 'All goods'); ?>
                    <?= (!is_null($currentCategory)) ? '| категория: '.$currentCategory->title : ''; ?><?= (!is_null($currentBrand)) ? ' | бренд: '.$currentBrand->title : '' ?></p>
                <div class="clearfix"></div>
            </div>
            <?= ListView::widget([
                                     'dataProvider'     => $productProvider,
                                     'itemView'         => '_listItem_v2',
                                     'layout'           => '<div class="panel-body"><div class="sorter-wrap">{sorter}</div><div class="row">{items}</div></div><div class="panel-footer "><div class="left">{summary}</div><div class="right">{pager}</div><div class="clearfix"></div></div>',
                                     'emptyTextOptions' => [
                                         'class' => 'alert alert-warning',
                                         'style' => 'margin: 10px;'
                                     ]
                                 ]) ?>
        </div>

    </div>
</div>
