<?php
    /**
     * @var $model \common\models\ProductModel
     */
    use common\models\forms\CartForm;
    use yii\alexposseda\fileManager\FileManager;
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;
    use yii\helpers\Url;

    $src = (!empty($model->cover)) ? $model->cover : '/img/noPicture.png';
    $cartModel = new CartForm();
?>

<div class="col-sm-12 col-md-6 col-lg-4 product-wrap">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= $model->title ?></h3>
            <br>
            <div class="btn-group btn-group-justified">
                <?= Html::a(Yii::t('system/view', 'View'), [
                    'product/view',
                    'id' => $model->id
                ], ['class' => 'btn btn-sm btn-primary']) ?>
                <?= Html::a(Yii::t('system/view', 'Update'), [
                    'product/update',
                    'id' => $model->id
                ], ['class' => 'btn btn-sm btn-warning']) ?>
                <?= Html::a(Yii::t('system/view', 'Delete'), [
                    'product/delete',
                    'id' => $model->id
                ], [
                                'class' => 'btn btn-sm btn-danger',
                                'data'  => [
                                    'confirm' => Yii::t('system/view', 'Are you sure you want to delete this item?'),
                                    'method'  => 'post',
                                ],
                            ]) ?>
            </div>
        </div>
        <div class="panel-body">
            <?= Html::img($src, ['class' => 'img-responsive img-thumbnail']) ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <caption>Опции</caption>
                    <?php
                        foreach($model->productCharacteristicItems as $productCharacteristicItem):
                            if($productCharacteristicItem->characteristic->isOption):
                                ?>
                                <tr>
                                    <td class="option-name"><?= $productCharacteristicItem->characteristic->title ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-primary"><?= $productCharacteristicItem->value ?></button>
                                            <?php
                                                $u_chars = [$productCharacteristicItem->value];
                                                foreach($model->relatedProducts as $rel_product):
                                                    $v = $rel_product->relatedProduct->characteristicValue($productCharacteristicItem->characteristic->id)->value;
                                                    if(!in_array($v, $u_chars)):?>
                                                        <a class="btn btn-sm btn-default" href="<?= Url::to([
                                                                                                         'product/view',
                                                                                                         'id' => $rel_product->relatedProduct->id
                                                                                                     ]) ?>">
                                                            <?= $v ?>
                                                        </a>
                                                        <?php
                                                        $u_chars[] = $v;
                                                    endif;
                                                endforeach;
                                                foreach($model->relatedProducts0 as $rel_product):
                                                    $v = $rel_product->baseProduct->characteristicValue($productCharacteristicItem->characteristic->id)->value;
                                                    if(!in_array($v, $u_chars)):?>
                                                        <a class="btn btn-sm btn-default" href="<?= Url::to([
                                                                                                         'product/view',
                                                                                                         'id' => $rel_product->baseProduct->id
                                                                                                     ]) ?>">
                                                            <?= $v ?>
                                                        </a>
                                                        <?php
                                                        $u_chars[] = $v;
                                                    endif;
                                                endforeach;
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            endif;
                        endforeach;
                    ?>
                    <?php
                        if(!empty($model->productCharacteristicItems)):
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <caption>Характеристики</caption>
                                    <?php
                                        foreach($model->productCharacteristicItems as $productCharacteristic):
                                            ?>
                                            <tr>
                                                <td><strong><?= $productCharacteristic->characteristic->title ?></strong></td>
                                                <td><?= $productCharacteristic->value ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    ?>
                                </table>
                            </div>
                            <?php
                        else:
                            ?>
                            <div class="alert alert-info">Характеристики не заданы</div>
                            <?php
                        endif;
                    ?>
            </div>
            <div class="panel-footer text-center">
                <p><strong>Цена:</strong> <?= $model->base_price ?> | <strong>Количество:</strong> <?= $model->base_quantity ?></p>
                <?php $cartForm = ActiveForm::begin([
                                                        'action'  => Url::to(['/cart/add-to-cart'], 1),
                                                        'options' => [
                                                            'data-pjax' => 1,
                                                            'class'     => 'form-inline '
                                                        ]
                                                    ]) ?>
                <?= Html::activeHiddenInput($cartModel, 'product_id', ['value' => $model->id]) ?>
                <?= Html::activeInput('number', $cartModel, 'quantity', [
                    'class' => 'form-control',
                    'style' => 'width: 75px;'
                ]) ?>
                <?= Html::submitButton('Купить', ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
