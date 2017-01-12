<?php
    /**
     * @var $this   \yii\web\View
     * @var $orders \yii\data\ActiveDataProvider
     */
    use yii\bootstrap\Html;
    use yii\grid\GridView;
    use yii\helpers\Url;
    use yii\widgets\Pjax;

//    var_dump($orders->models);
?>
<?php Pjax::begin()?>
<?= GridView::widget([
                         'dataProvider' => $orders,
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
                             [
                                 'attribute'      => 'status',
                                 'headerOptions'  => [
                                     'style' => 'width: 20%;max-width: 150px;'
                                 ],
                                 'contentOptions' => ['style' => 'vertical-align:middle;'],
                                 'content'        => function($data){
                                     return Yii::t('models/order', $data->status);
                                 }
                             ],
                             [
                                 'attribute'      => 'orderClientData.client.name',
                                 'headerOptions'  => [
                                     'style' => 'width: 20%;max-width: 150px;'
                                 ],
                                 'contentOptions' => ['style' => 'vertical-align:middle;'],
                                 'content'        => function($data){
                                     /** @var \common\models\OrderModel $data */
                                     return Html::a($data->orderClientData->client->name,
                                                    ['/client/view', 'id' => $data->orderClientData->client_id]);
                                 }
                             ],
                             [
                                 'attribute'      => 'delivery.name',
                                 'headerOptions'  => [
                                     'style' => 'width: 30%;max-width: 280px;'
                                 ],
                                 'contentOptions' => ['style' => 'vertical-align:middle;']
                             ],
                             [
                                 'attribute'      => 'delivery.price',
                                 'headerOptions'  => [
                                     'style' => 'width: 30%;max-width: 280px;'
                                 ],
                                 'contentOptions' => ['style' => 'vertical-align:middle;'],
                                 'content'        => function($data){
                                     /** @var \common\models\OrderModel $data */
                                     return $data->delivery->price == 0 ? '<span class="text-success">'.Yii::t('models/order', 'Free delivery').'</span>' : $data->delivery->price;
                                 }
                             ],
                             [
                                 'attribute'      => 'payment.name',
                                 'headerOptions'  => [
                                     'style' => 'width: 30%;max-width: 280px;'
                                 ],
                                 'contentOptions' => ['style' => 'vertical-align:middle;']
                             ],
                             [
                                 'attribute'      => 'total_cost',
                                 'headerOptions'  => [
                                     'style' => 'width: 30%;max-width: 280px;'
                                 ],
                                 'contentOptions' => ['style' => 'vertical-align:middle;']
                             ],
                             [
                                 'attribute'      => 'created_at',
                                 'format'         => [
                                     'date',
                                     'H:m:s dd.MM.Y'
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
                                     'H:m:s dd.MM.Y'
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
                         ]
                     ]); ?>
<?php Pjax::end()?>
<a href="<?= Url::to(['cart/index']) ?>" class="btn btn-sm btn-success pull-right">
    Перейти в корзину
</a>
