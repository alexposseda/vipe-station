<?php

    use yii\helpers\Html;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;

    /* @var $this yii\web\View */
    /* @var $searchModel common\models\search\ProductSearchModel */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('models', 'Products');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-model-index">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <p>
                <?= Html::a(Yii::t('system/view', 'Create').' '.Yii::t('models', 'Product'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </p>
        </div>
        <div class="col-md-12 col-lg-9">
            <?= ListView::widget([
                                     'dataProvider' => $dataProvider,
                                     'itemOptions'  => ['class' => 'item'],
                                     'itemView'     => '_itemProduct',
                                 ]) ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
