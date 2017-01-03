<?php

    use yii\grid\GridView;
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
            <?= GridView::widget([
                                     'dataProvider' => $dataProvider,
                                     'columns'      => [
                                         [
                                             'attribute'      => 'id',
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                         [
                                             'attribute'      => 'title',
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                         [
                                             'attribute'      => 'cover',
                                             'label'          => false,
                                             'headerOptions'  => [
                                                 'style' => 'width: 10%;max-width: 80px;'
                                             ],
                                             'content'        => function($data){
                                                 $logo = $data->getCover();
                                                 if(empty($logo)){
                                                     $logo = ['/img/noPicture.png'];
                                                 }

                                                 return Html::img($logo, [
                                                     'class' => 'img-circle',
                                                     'style' => 'width: 100%; max-width: 80px;'
                                                 ]);
                                             },
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                         [
                                             'label'          => Yii::t('models', 'Categories'),
                                             'content'        => function($data){
                                                 $html = '';
                                                 foreach($data->categories as $category){
                                                     $html .= Html::tag('p', Html::a($category->title, [
                                                         '/category/view',
                                                         'id' => $category->id
                                                     ]));
                                                 }

                                                 return $html;
                                             },
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                         [
                                             'label'          => Yii::t('models', 'Brand'),
                                             'content'        => function($data){
                                                 return Html::a($data->brand->title, [
                                                     '/brand/view',
                                                     'id' => $data->brand->id
                                                 ]);
                                             },
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                         [
                                             'attribute'      => 'base_price',
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                         [
                                             'attribute'      => 'base_quantity',
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                         [
                                             'class'          => 'yii\grid\ActionColumn',
                                             'headerOptions'  => [
                                                 'style' => 'width: 7%;max-width: 60px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                     ]
                                 ]) ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
