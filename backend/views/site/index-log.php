<?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;

    /* @var $this yii\web\View */
    /* @var $searchModel common\models\search\LogSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('models', 'Log');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <p>
                <?php echo $this->render('_search_log', ['model' => $searchModel]); ?>
            </p>
        </div>
        <div class="col-md-12 col-lg-9">
            <?= GridView::widget([
                                     'dataProvider' => $dataProvider,
                                     'filterModel'  => null,
                                     'columns'      => [
                                         [
                                             'attribute'      => 'id',
                                             'headerOptions'  => [
                                                 'style' => 'width: 2%;max-width: 50px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']

                                         ],
                                         [
                                             'attribute'      => 'action',
                                             'headerOptions'  => [
                                                 'style' => 'width: 20%;max-width: 150px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']

                                         ],
                                         [
                                             'attribute'      => 'action_data',
                                             'headerOptions'  => [
                                                 'style' => 'width: 30%;max-width: 280px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']

                                         ],

                                         [
                                             'attribute'      => 'initializer',
                                             'headerOptions'  => [
                                                 'style' => 'width: 20%;max-width: 150px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']

                                         ],
                                         [
                                             'attribute'      => 'user_id',
                                             'headerOptions'  => [
                                                 'style' => 'width: 2%;max-width: 50px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']

                                         ],
                                         [
                                             'attribute'      => 'updated_at',
                                             'format'         => [
                                                 'date',
                                                 'HH:mm:ss dd.MM.YYYY'
                                             ],
                                             'headerOptions'  => [
                                                 'style' => 'width: 10%;max-width: 100px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                         [
                                             'class'          => 'yii\grid\ActionColumn',
                                             'headerOptions'  => [
                                                 'style' => 'width: 7%;max-width: 60px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']
                                         ],
                                     ],
                                 ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>