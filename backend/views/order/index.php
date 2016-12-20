<?php
    /**
     * @var $this   \yii\web\View
     * @var $orders \yii\data\ActiveDataProvider
     */
    use yii\grid\GridView;

?>
<?= GridView::widget([
                         'dataProvider' => $orders
                     ]);
