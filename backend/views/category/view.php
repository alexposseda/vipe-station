<?php

    use backend\widgets\ProductWidget\ProductInCategoryWidget;
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model common\models\CategoryModel
     * @var $products common\models\ProductModel
     */

    $this->title = $model->title;
    $this->params['breadcrumbs'][] = [
        'label' => 'Category Models',
        'url'   => ['index']
    ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
                            'confirm' => Yii::t('system/views', 'Are you sure you want to delete this item?'),
                            'method'  => 'post',
                        ],
                    ]) ?>
    </p>

    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-5">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= DetailView::widget([
                                               'model'      => $model,
                                               'attributes' => [
                                                   'id',
                                                   'title',
                                                   //                                   'slug',
                                                   //                                   'seo_id',
                                                   'created_at:datetime',
                                                   'updated_at:datetime',
                                               ],
                                           ]) ?>
                </div>
            </div>
        </div>
        <?php if(!is_null($model->products)): ?>
            <div class="col-sm-12 col-md-9 col-lg-7">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?= ProductInCategoryWidget::widget([
                                                                'id' => $model->id,
                                                            ]) ?>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>
</div>
