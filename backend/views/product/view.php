<?php

    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model common\models\ProductModel */

    $this->title = $model->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Products'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('system/view', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
                               'model'      => $model,
                               'attributes' => [
                                   'id',
                                   'title',
                                   'gallery:ntext',
                                   'description:ntext',
                                   'base_price',
                                   'base_quantity',
                                   'slug',
                                   'sales',
                                   'views',
                                   'seo_id',
                                   'created_at',
                                   'updated_at',
                                   'brand_id',
                               ],
                           ]) ?>

</div>
