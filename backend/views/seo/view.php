<?php

    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model common\models\SeoModel */

    $this->title = $model->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Seo'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('system/view', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('system/view', 'Delete'), ['delete', 'id' => $model->id], [
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
                                   'keywords',
                                   'description',
                                   'seo_block:ntext',
                                   'created_at:datetime',
                                   'updated_at:datetime',
                               ],
                           ]) ?>

</div>
