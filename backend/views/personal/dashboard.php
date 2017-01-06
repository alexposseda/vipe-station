<?php
/**
 * @var $this \yii\web\View
 *
 */
use common\models\ClientModel;
use common\models\LogModel;
use common\models\OrderModel;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-lg-7">
        <div class="panel panel-danger orders">
            <div class="panel-heading">
                <a href="<?= Url::to(['create-order-by-client']) ?>" class="btn btn-sm btn-success pull-right">
                    Добавить заказ от клиента <span class="glyphicon glyphicon-plus"></span>
                </a>
                <p class="page-title">Последние заказы</p>
                <div class="clearfix"></div>
            </div>
            <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider(['query' => OrderModel::find()->orderBy(['created_at' => SORT_DESC])]),
                'layout' => '<div class="panel-body"><div class="row">{items}</div></div><div class="panel-footer "><div class="left">{summary}</div><div class="right">{pager}</div><div class="clearfix"></div></div>',
                'emptyTextOptions' => ['class' => 'alert alert-warning', 'style' => 'margin: 10px;'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'status',
                    'orderClientData.client.name',
                    'total_cost',
                    [
                        'attribute' => 'updated_at',
                        'format' => [
                            'date',
                            'H:m:s dd.MM.Y'
                        ],
                        'headerOptions' => [
                            'style' => 'width: 10%;max-width: 100px;'
                        ],
                        'contentOptions' => ['style' => 'vertical-align:middle;']
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'urlCreator' => function ($action, $model, $key, $index) {
                            return Url::to(['order/' . $action, 'id' => $model->id]);
                        }],
                ]
            ]) ?>
        </div>
        <div class="panel panel-info clients">
            <div class="panel-heading">
                <a href="<?= Url::to(['client/create']) ?>" class="btn btn-sm btn-success pull-right">
                    Добавить клиента <span class="glyphicon glyphicon-plus"></span>
                </a>
                <p class="page-title">Последние клиенты</p>
                <div class="clearfix"></div>
            </div>
            <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider(['query' => ClientModel::find()->orderBy(['created_at' => SORT_DESC])]),
                'layout' => '<div class="panel-body"><div class="row">{items}</div></div><div class="panel-footer "><div class="left">{summary}</div><div class="right">{pager}</div><div class="clearfix"></div></div>',
                'emptyTextOptions' => ['class' => 'alert alert-warning', 'style' => 'margin: 10px;'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'email',
                    'name',
                    [
                        'attribute' => 'updated_at',
                        'format' => [
                            'date',
                            'H:m:s dd.MM.Y'
                        ],
                        'headerOptions' => [
                            'style' => 'width: 10%;max-width: 100px;'
                        ],
                        'contentOptions' => ['style' => 'vertical-align:middle;']
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'urlCreator' => function ($action, $model, $key, $index) {
                            return Url::to(['client/' . $action, 'id' => $model->id]);
                        }
                    ],
                ]
            ]) ?>
        </div>
    </div>
    <div class="col-lg-5 logger">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <p class="panel-title"> Логирование</p>
                <div class="clearfix"></div>
            </div>
            <?= GridView::widget(
                [
                    'dataProvider' => new ActiveDataProvider(['query' => LogModel::find()]),
                    'columns' => [
                        'action',
                        'initializer',
                        'user_id'
                    ],
                    'layout' => '<div class="panel-body"><div class="row">{items}</div></div><div class="panel-footer "><div class="left">{summary}</div><div class="right">{pager}</div><div class="clearfix"></div></div>',
                    'emptyTextOptions' => ['class' => 'alert alert-warning', 'style' => 'margin: 10px;']
                ]) ?>
        </div>
    </div>
</div>
