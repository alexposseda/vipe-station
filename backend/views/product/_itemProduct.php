<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\ProductModel
     */
    use yii\bootstrap\Html;
    use yii\widgets\DetailView;

?>

<?= DetailView::widget([
                           'model'      => $model,
                           'attributes' => [
                               'title',
                               'cover:image',
                               'description:ntext',
                               'base_price',
                               'base_quantity',
                               'seo.title',
                               'brand.title',
                           ],
                       ]) ?>
<?= Html::a(Yii::t('system/view', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<?= Html::a(Yii::t('system/view', 'Delete'), ['delete', 'id' => $model->id], [
    'class' => 'btn btn-danger',
    'data'  => [
        'confirm' => Yii::t('system/view', 'Are you sure you want to delete this item?'),
        'method'  => 'post',
    ],
]) ?>
