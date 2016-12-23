<?php
    /**
     * @var $this   \yii\web\View
     * @var $orders \yii\data\ActiveDataProvider
     */
    use yii\grid\GridView;

?>
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
                                 'contentOptions' => ['style' => 'vertical-align:middle;']
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
                                 'contentOptions' => ['style' => 'vertical-align:middle;']
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

                             [
                                 'class'          => 'yii\grid\ActionColumn',
                                 'headerOptions'  => [
                                     'style' => 'width: 7%;max-width: 60px;'
                                 ],
                                 'contentOptions' => ['style' => 'vertical-align:middle;']
                             ],
                         ]
                     ]);
