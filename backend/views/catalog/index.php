<?php
    /**
     * @var $this            \yii\web\View
     * @var $productProvider \yii\data\ActiveDataProvider
     */
    use yii\helpers\Html;
    use yii\widgets\ListView;

?>

<?= ListView::widget([
                         'dataProvider' => $productProvider,
                         'itemView'     => '_listItem'
                     ]) ?>

<?=Html::a('Оформить',[''])?>
