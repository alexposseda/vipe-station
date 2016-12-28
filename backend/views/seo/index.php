<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SeoSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('models', 'Seo');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <p>
                <?= Html::a(Yii::t('system/view', 'Create') . ' ' . Yii::t('models', 'Seo'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </p>
        </div>
        <div class="col-md-12 col-lg-9">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'title',
                    [
                        'label' => 'parent',
                        'content' => function ($data) {
                            return Html::a($data->getParent()->title, $data->link);
                        }
                    ],
                    //'keywords',
                    //'description',
                    //'seo_block:ntext',
                    //created_at:datetime',
                    //'updated_at:datetime',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
