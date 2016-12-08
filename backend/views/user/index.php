<?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider
     * @var $searchModel  common\models\search\UserSearch
     */

    $this->title = Yii::t('models', 'Users');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <p>
                <?= Html::a(Yii::t('system/view', 'Create').' '.Yii::t('models/user', 'User'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </p>
        </div>
        <div class="col-md-12 col-lg-9">
            <?= GridView::widget([
                                     'dataProvider' => $dataProvider,
                                     'filterModel'  => null,
                                     'layout'       => "{summary}\n<div class='table-responsive'>\n{items}\n</div>\n{pager}",
                                     'columns'      => [
                                         [
                                             'attribute'      => 'id',
                                             'headerOptions'  => [
                                                 'style' => 'width: 2%;max-width: 50px;'
                                             ],
                                             'contentOptions' => ['style' => 'vertical-align:middle;']

                                         ],
                                         'email:email',
                                         [
                                             'attribute'      => 'created_at',
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
                                         'role',

                                         ['class' => 'yii\grid\ActionColumn'],
                                     ],
                                 ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
