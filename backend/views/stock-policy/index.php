<?php

    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('models', 'Stocks').' '.Yii::t('models/stock', 'Policy');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-policy-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <p>
                <?= Html::a(Yii::t('system/view', 'Create').' '.Yii::t('models/stock', 'Stock').' '.Yii::t('models/stock', 'Policy'), ['create'],
                            ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-md-12 col-lg-9">
            <?= GridView::widget([
                                     'dataProvider' => $dataProvider,
                                     'columns'      => [
                                         ['class' => 'yii\grid\SerialColumn'],

                                         'id',
                                         'name',
                                         //            'created_at',
                                         //            'updated_at',

                                         ['class' => 'yii\grid\ActionColumn'],
                                     ],
                                 ]); ?>
        </div>
    </div>
</div>
