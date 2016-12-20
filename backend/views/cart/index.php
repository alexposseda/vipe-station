<?php

    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('models', 'Cart');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],

                                 'id',
                                 'user.client.name',
                                 'guest_id',
                                 'product.title',
                                 [
                                     'attribute' => 'product.cover',
                                     'format'    => 'image',
                                     'content'   => function($model){
                                         return Html::img(FileManager::getInstance()
                                                                     ->getStorageUrl().$model->product->cover, [
                                                              'class' => 'img-thumbnail',
                                                              'style' => 'width: 100%; max-width: 80px;'
                                                          ]);
                                     }
                                 ],

                                 'options',
                                 'quantity',

                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>
</div>
