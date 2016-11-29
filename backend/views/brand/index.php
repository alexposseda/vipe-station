<?php
    use yii\bootstrap\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;

    /* @var $this yii\web\View */
    /* @var $searchModel common\models\search\BrandSearchModel */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('models', 'Brands');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <p>
                <?= Html::a(Yii::t('system/view','Create').' '.Yii::t('models', 'Brand'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </p>
        </div>
        <div class="col-md-12 col-lg-9">
            <?= GridView::widget([
                                     'dataProvider' => $dataProvider,
                                     //                             'filterModel'  => $searchModel,
                                     'filterModel'  => null,
                                     'layout'       => "{summary}\n<div class='table-responsive'>\n{items}\n</div>\n{pager}",
                                     'columns'      => [
                                         [
                                             'class'         => 'yii\grid\SerialColumn',
                                             'headerOptions' => [
                                                 'style' => 'width: 1%;min-width: 25px;'
                                             ]
                                         ],
                                         [
                                             'attribute'     => 'id',
                                             'headerOptions' => [
                                                 'style' => 'width: 2%;min-width: 50px;'
                                             ]

                                         ],
                                         [
                                             'attribute'     => 'title',
                                             'headerOptions' => [
                                                 'style' => 'width: 20%;min-width: 150px;'
                                             ]

                                         ],
                                         [
                                             'attribute'     => 'cover',
                                             'headerOptions' => [
                                                 'style' => 'width: 10%;min-width: 80px;'
                                             ],
                                             'content'       => function($data){
                                                 return Html::img($data->cover, [
                                                     'class' => 'img-circle',
                                                     'style' => 'width: 100%; max-width: 80px;'
                                                 ]);
                                             }
                                         ],
                                         [
                                             'attribute'     => 'description',
                                             'headerOptions' => [
                                                 'style' => 'width: 30%;min-width: 280px;'
                                             ]

                                         ],
                                         [
                                             'attribute'     => 'slug',
                                             'content'       => function($data){
                                                 return Html::a($data->slug, [
                                                     'brand/view',
                                                     'language' => Yii::$app->language,
                                                     'id'       => $data->id
                                                 ]);
                                             },
                                             'headerOptions' => [
                                                 'style' => 'width: 10%;min-width: 100px;'
                                             ]
                                         ],
                                         [
                                             'attribute'     => 'updated_at',
                                             'format'        => [
                                                 'date',
                                                 'HH:mm:ss dd.MM.YYYY'
                                             ],
                                             'headerOptions' => [
                                                 'style' => 'width: 10%;min-width: 100px;'
                                             ]
                                         ],
                                         [
                                             'class'         => 'yii\grid\ActionColumn',
                                             'headerOptions' => [
                                                 'style' => 'width: 7%;min-width: 60px;'
                                             ]
                                         ],
                                     ],
                                 ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
