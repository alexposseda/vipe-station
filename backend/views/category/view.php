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
        'label' => Yii::t('models/base', 'Categories'),
        'url'   => ['index']
    ];
    $this->params['breadcrumbs'][] = $this->title;

    $allCharacter = \common\models\CategoryModel::allCharacteristics($model->id);
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
                            'confirm' => Yii::t('system/view', 'Are you sure you want to delete this item?'),
                            'method'  => 'post',
                        ],
                    ]) ?>
    </p>

    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-5">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td>ID</td>
                                <td><?= $model->id ?></td>
                            </tr>
                            <tr>
                                <td>Title</td>
                                <td><?= $model->title ?></td>
                            </tr>
                            <tr>
                                <td>Parent Category</td>
                                <td><?= ($model->parent0) ? Html::a($model->parent0->title, [
                                        'category/view',
                                        'id' => $model->parent0->id
                                    ]) : 'not set' ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center"><strong>Характеристики</strong></td>
                            </tr>
                            <?php if(!empty($allCharacter)):
                                foreach($allCharacter as $p_char):
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text-center"><?= $p_char->title?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            else:
                                ?>
                                <tr class="info">
                                    <td colspan="2" class="text-center">Не задано...</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
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
