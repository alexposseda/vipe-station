<?php
    /**
     * @var $this            \yii\web\View
     * @var $productProvider \yii\data\ActiveDataProvider
     */

    use yii\widgets\ListView;

?>
<div class="row">
    <?php \yii\widgets\Pjax::begin() ?>
    <?= ListView::widget([
                             'dataProvider' => $productProvider,
                             'itemView'     => '_listItem',
                             'separator'    => ''
                         ]) ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>
