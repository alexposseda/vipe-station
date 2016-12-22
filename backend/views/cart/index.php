<?php

    use common\models\ProductOptionModel;
    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('models', 'Cart');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a(Yii::t('models/cart', 'Zakaz'), ['/order/create'], ['class' => 'btn btn-primary']) ?>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 [
                                     'label'   => Yii::t('models/cart', 'Name'),
                                     'content' => function($data){
                                         if($data->user_id){
                                             return $data->user->client->name;
                                         }elseif($data->guest_id){
                                             return Yii::t('models/cart', 'Guest');
                                         }
                                     }
                                 ],
                                 'product.title',
                                 'product.cover:image',
                                 'quantity',
                                 'product.base_price',
                                 [
                                     'label'   => 'опции',
                                     'content' => function($data){
                                         $html = ' ';
                                         /** @var \common\models\CartModel $data */
                                         if($data->options){
                                             $options = json_decode($data->options);
                                             if(!empty($options->options)){
                                                 foreach($options->options as $option){
                                                     $optionModel = ProductOptionModel::findOne($option);
                                                     $html .= $optionModel->characteristic->title.' '.$optionModel->delta_price.'<br>';
                                                 }
                                             }
                                         }

                                         return $html;
                                     }
                                 ],
                                 'price',

                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>
</div>
