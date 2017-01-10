<?php

    use common\models\forms\CartForm;
    use common\models\ProductModel;
    use common\models\ProductOptionModel;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\helpers\Url;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('models', 'Cart');
    $this->params['breadcrumbs'][] = $this->title;

    $this->registerJsFile('js/cart.js', ['depends' => \backend\assets\AppAsset::className()]);
?>
<div class="cart-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a(Yii::t('models/cart', 'Zakaz'), ['/order/create'], ['class' => 'btn btn-primary']) ?>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 //                                 [
                                 //                                     'label'   => Yii::t('models/cart', 'Name'),
                                 //                                     'content' => function($data){
                                 //                                         if($data->user_id){
                                 //                                             return $data->user->client->name;
                                 //                                         }elseif($data->guest_id){
                                 //                                             return Yii::t('models/cart', 'Guest');
                                 //                                         }
                                 //                                     }
                                 //                                 ],
                                 'product.cover:image',
                                 [
                                     'attribute' => 'product.title',
                                     'content'   => function($data){
                                         return Html::a($data->product->title, Url::to(['product/view', 'id' => $data->product->id]));
                                     }
                                 ],
                                 [
                                     'label'   => 'опции',
                                     'content' => function($data){
                                         $html = '';
                                         /** @var \common\models\CartModel $data */
                                         $options = ProductModel::getOptions($data->product);
                                         foreach($options as $product_id => $productOptions){
                                             if($product_id == $data->product_id){
                                                 foreach($productOptions as $option){
                                                     $html .= $option['title'].' '.$option['value'].'<br>';
                                                 }
                                             }
                                         }

                                         return $html;
                                     }
                                 ],
                                 [
                                     'attribute' => 'quantity',
                                     'content'   => function($data){
                                         return '<div class="input-group count-inp" data-url="'.Url::to(['cart/change-quantity', 'product_id'=>$data->product_id]).'"><span class="quantity-btn" data-action="minus">-</span><input type="text" readonly value="'.$data->quantity.'"><span class="quantity-btn" data-action="plus">+</span></div>';
                                     }
                                 ],
                                 'product.base_price',
                                 'price',
                                 [
                                     'class'    => 'yii\grid\ActionColumn',
                                     'template' => '{delete}'
                                 ],
                             ],
                         ]); ?>
</div>
