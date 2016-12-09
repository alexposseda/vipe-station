<?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;

    /**
     * @var $this         yii\web\View
     * @var $dataProvider yii\data\ActiveDataProvider
     */

    $this->title = Yii::t('models', 'Stock');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <p>
                <?= Html::a(Yii::t('system/view', 'Create').' '.Yii::t('models/payment', 'Stock'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-md-12 col-lg-9">
            <?= GridView::widget([
                                     'dataProvider' => $dataProvider,
                                     'layout'       => "{summary}\n<div class='table-responsive'>\n{items}\n</div>\n{pager}",
                                     'columns'      => [
                                         'title',
                                         'date_start:datetime',
                                         'date_end:datetime',
                                         [
                                             'class'          => 'yii\grid\ActionColumn',
                                             'headerOptions'  => [
                                                 'style' => 'width: 7%;max-width: 60px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                     ]
                                 ]) ?>
        </div>
    </div>
    <?php Pjax::end(); ?>

</div>