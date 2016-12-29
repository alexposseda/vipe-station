<?php
    /**
     * @var $model \common\models\ProductModel
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\bootstrap\Html;

    $src = (!empty($model->cover)) ? FileManager::getInstance()
                                                ->getStorageUrl().json_decode($model->cover)[0] : '/img/noPicture.png';
?>

<div class="col-sm-12 col-md-6 col-lg-6 product-wrap">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-7">
                    <h3><?= $model->title ?></h3>
                    <hr>
                    <p><strong>Цена:</strong> <?= $model->base_price ?></p>
                    <p><strong>Количество:</strong> <?= $model->base_quantity ?></p>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-5">
                    <?= Html::img($src, ['class' => 'img-responsive img-responsive']) ?>
                </div>
            </div>
            <hr>
            <?php
                if(!empty($model->productOptions)):
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-condensed">
                            <caption>Доступные опции</caption>
                            <tr>
                                <td>Название</td>
                                <td>Значение</td>
                                <td>Цена</td>
                                <td>Количество</td>
                            </tr>
                            <?php
                                foreach($model->productOptions as $productOption):
                                    ?>
                                    <tr>
                                        <td><?= $productOption->characteristic->title ?></td>
                                        <td><?= $productOption->value ?></td>
                                        <td><?= $productOption->delta_price ?></td>
                                        <td><?= $productOption->quantity ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            ?>
                        </table>
                    </div>
                    <?php
                else:
                    ?>
                    <div class="alert alert-info">Опции не найдены</div>
                    <?php
                endif;
            ?>
            <hr>
            <h4>Описание</h4>
            <p><?= $model->description ?></p>
            <hr>
            <?php
                if(!empty($model->productCharacteristicItems)):
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <caption>Характеристики</caption>
                            <tr>
                                <td>Название</td>
                                <td>Значение</td>
                            </tr>
                            <?php
                                foreach($model->productCharacteristicItems as $productCharacteristic):
                                    ?>
                                    <tr>
                                        <td><?= $productCharacteristic->characteristic->title ?></td>
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
        <div class="panel-footer">
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
    </div>
</div>
