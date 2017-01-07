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
            <div class="panel-footer text-center">
                <p><strong>Цена:</strong> <?= $model->base_price ?></p>
                    <p><strong>Количество:</strong> <?= $model->base_quantity ?></p>
            </div>
        </div>
    </div>
</div>
