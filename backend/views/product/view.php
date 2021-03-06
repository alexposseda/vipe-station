<?php

    use common\models\forms\CartForm;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;

    /* @var $this yii\web\View */
    /* @var $model common\models\ProductModel */

    $this->title = $model->title;
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('models', 'Products'),
        'url'   => ['index']
    ];
    $this->params['breadcrumbs'][] = $this->title;

    $cartModel = new CartForm();
    $gallery = $model->gallery;
    if(!empty($gallery)){
        $gallery = json_decode($gallery);
    }

    $this->registerJsFile('/js/product_form.js', [
        'position' => \yii\web\View::POS_END,
        'depends'  => \backend\assets\AppAsset::className()
    ]);
?>
<div class="product-model-view">
    <p class="pull-left">
        <?= Html::a(Yii::t('system/view', 'Update'), [
            'update',
            'id' => $model->id
        ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('system/view', 'Delete'), [
            'delete',
            'id' => $model->id
        ], [
                        'class' => 'btn btn-danger',
                        'data'  => [
                            'confirm' => Yii::t('system/view', 'Are you sure you want to delete this item?'),
                            'method'  => 'post',
                        ],
                    ]) ?>
    </p>
    <div class="pull-right">
        <?php $cartForm = ActiveForm::begin([
                                                'action' => Url::to(['/cart/add-to-cart'], 1),
                                                'options' => [
                                                    'data-pjax' => 1,
                                                    'class'     => 'form-inline'
                                                ]
                                            ]) ?>
        <?= Html::activeHiddenInput($cartModel, 'product_id', ['value' => $model->id]) ?>
        <?= Html::activeInput('number', $cartModel, 'quantity', [
            'class'              => 'form-control',
            'style'              => 'width: 75px;',
            'data-base_quantity' => $model->base_quantity
        ]) ?>
        <?= Html::submitButton('Купить', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end() ?>
        <div class ="btn btn-primary">
            <a href="<?= Url::to(['cart/index']) ?>" class="btn btn-sm btn-success pull-right">
                Перейти в корзину
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-4">
            <div class="list-group">
                <div class="list-group-item text-center"><h3>Общая информация</h3></div>
                <div class="list-group-item"><strong>Назание:</strong> <?= Html::encode($this->title) ?></div>
                <div class="list-group-item"><strong>Id товара:</strong> <?= $model->id ?></div>
                <a href="<?= Url::to([
                                         'brand/view',
                                         'id' => $model->brand_id
                                     ]) ?>"
                   class="list-group-item list-group-item-info"><strong>Бренд:</strong> <?= $model->brand->title ?></a>
                <div class="list-group-item text-center"><h3>Категории</h3></div>
                <?php foreach($model->categories as $category): ?>
                    <a class="list-group-item list-group-item-info" href="<?= Url::to([
                                                                                          'category/view',
                                                                                          'id' => $category->id
                                                                                      ]) ?>"><?= $category->title ?></a>
                <?php endforeach; ?>
                <div class="list-group-item text-center"><h3>Опции</h3></div>
                <?php
                    $options = \common\models\ProductModel::getOptions($model);
                    if(!empty($options)):
                        foreach($options as $product_id => $option_list):
                            if($product_id == $model->id):
                                ?>
                                <div class="list-group-item active">
                                    <?php foreach($option_list as $option):
                                        echo $option['title'].': '.$option['value'].'<br>';
                                    endforeach; ?>
                                </div>
                                <?php
                            else:
                                ?>
                                <a class="list-group-item" href="<?= Url::to([
                                                                                 'product/view',
                                                                                 'id' => $product_id
                                                                             ]) ?>">
                                    <?php foreach($option_list as $option):
                                        echo $option['title'].': '.$option['value'].'<br>';
                                    endforeach; ?>
                                </a>
                                <?php
                            endif;
                        endforeach;
                    else:
                        ?>
                        <div class="list-group-item list-group-item-danger">Нет опции</div>
                    <?php endif; ?>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <p class="panel-title">Seo</p>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed table-striped" style="margin-bottom: 0;">
                        <tr>
                            <td>Ярлык</td>
                            <td><?= $model->slug ?></td>
                        </tr>
                        <tr>
                            <td>Title</td>
                            <td><?= $model->seo->title ?></td>
                        </tr>
                        <tr>
                            <td>KeyWords</td>
                            <td><?= $model->seo->keywords ?></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td><?= $model->seo->description ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-8">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td>Цена</td>
                                    <td class="text-center"><?= $model->base_price ?> грн</td>
                                </tr>
                                <tr>
                                    <td>Количество</td>
                                    <td class="text-center"><?= $model->base_quantity ?> шт</td>
                                </tr>
                            </table>
                            <table class="table table-condensed table-bordered" style="margin-bottom: 0;">
                                <tr>
                                    <td>Просмотры</td>
                                    <td class="text-center"><?= $model->views ?></td>
                                </tr>
                                <tr>
                                    <td>Покупки</td>
                                    <td class="text-center"><?= $model->sales ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">Характеристики</p>
                        </div>
                        <div class="panel-body">
                            <table class="table table-condensed table-striped table-bordered" style="margin-bottom: 0;">
                                <?php foreach($model->productCharacteristicItems as $prod_char): ?>
                                    <tr>
                                        <td><?= $prod_char->characteristic->title ?></td>
                                        <td><?= $prod_char->value ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <p class="panel-title">Описание</p>
                </div>
                <div class="panel-body">
                    <?= $model->description ?>
                </div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <p class="panel-title">Галерея</p>
                </div>
                <div class="panel-body">
                    <?php if(!empty($gallery)): foreach($gallery as $pic): ?>
                        <img src="<?= \yii\alexposseda\fileManager\FileManager::getInstance()
                                                                              ->getStorageUrl().$pic ?>" class="img-thumbnail">
                    <?php endforeach;
                    else: ?>
                        <div class="alert alert-info">Gallery is empty!</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
