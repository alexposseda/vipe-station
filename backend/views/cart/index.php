<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('models','Cart');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'guest_id',
            'product_id',
            'options',
            // 'quantity',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
