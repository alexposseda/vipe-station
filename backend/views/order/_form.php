<?php
    /**
     * @var $this  \yii\web\View
     * @var $order \common\models\forms\OrderForm
     */
    use common\models\DeliveryModel;
    use common\models\OrderModel;
    use common\models\PaymentModel;
    use common\models\ProductCharacteristicItemModel;
    use common\models\ProductOptionModel;
    use yii\bootstrap\ActiveForm;
    use yii\caching\DbDependency;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;

    $payArr = PaymentModel::getDb()
                          ->cache(function(){
                              return PaymentModel::find()
                                                 ->all();
                          }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM '.PaymentModel::tableName()]));
    $deliverArr = DeliveryModel::getDb()
                               ->cache(function(){
                                   return DeliveryModel::find()
                                                       ->all();
                               }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM '.DeliveryModel::tableName()]));
    $orderStatus = [
        OrderModel::ORDER_STATUS_ABORTED   => Yii::t('models/order', OrderModel::ORDER_STATUS_ABORTED),
        OrderModel::ORDER_STATUS_ACTIVE    => Yii::t('models/order', OrderModel::ORDER_STATUS_ACTIVE),
        OrderModel::ORDER_STATUS_CONFIRMED => Yii::t('models/order', OrderModel::ORDER_STATUS_CONFIRMED),
        OrderModel::ORDER_STATUS_DELETED   => Yii::t('models/order', OrderModel::ORDER_STATUS_DELETED),
        OrderModel::ORDER_STATUS_FINISHED  => Yii::t('models/order', OrderModel::ORDER_STATUS_FINISHED),
        OrderModel::ORDER_STATUS_PAID      => Yii::t('models/order', OrderModel::ORDER_STATUS_PAID),
        OrderModel::ORDER_STATUS_SENT      => Yii::t('models/order', OrderModel::ORDER_STATUS_SENT),
    ]
?>

<?php $orderForm = ActiveForm::begin() ?>
<div class="row">
    <div class="col-lg-8 left-panel">
        <?= $orderForm->field($order->order, 'payment_id')
                      ->dropDownList(ArrayHelper::map($payArr, 'id', 'name'), ['prompt' => 'Select Payment']) ?>
        <?= $orderForm->field($order->order, 'delivery_id')
                      ->dropDownList(ArrayHelper::map($deliverArr, 'id', 'name'), ['prompt' => 'Select Delivery']) ?>
        <?= $orderForm->field($order->order, 'status')
                      ->dropDownList($orderStatus, ['prompt' => 'Select order status']) ?>
        <div class="panel panel-default order-detail">
            <p class="panel-heading"><?= Yii::t('models/order', 'Order Data') ?></p>
            <div class="row">
                <?php if($order->orderData): ?>
                    <?php foreach($order->orderData as $index => $od): ?>
                        <div class="panel-body col-lg-4">
                            <div class="product-img">
                                <img src="<?= $od->product->cover ?>">
                            </div>
                            <div class="wrap-text-block">
                                <div class="product-title fs20 fc-orange">
                                    <?= Html::encode($od->product->title) ?>
                                </div>
                                <div class="product-brand fs15 fc-dark-brown">
                                    <p><?= Yii::t('models', 'Brand') ?></p>
                                    <?= Html::encode($od->product->brand->title) ?>
                                </div>
                                <div class="product-characteristics ">
                                    <p><?= Yii::t('models', 'Characteristics') ?></p>
                                    <?php if($od->options){
                                        $options = json_decode($od->options);
                                        if(!empty($options->characteristics)){
                                            foreach($options->characteristics as $character){
                                                $characterModel = ProductCharacteristicItemModel::findOne($character);
                                                echo $characterModel->characteristic->title.' '.$characterModel->value.'<br>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="product-options">
                                    <p><?= Yii::t('models', 'Options') ?></p>
                                    <?php if($od->options){
                                        $options = json_decode($od->options);
                                        if(!empty($options->options)){
                                            foreach($options->options as $option){
                                                $optionModel = ProductOptionModel::findOne($option);
                                                echo $optionModel->characteristic->title.' '.$optionModel->value.' '.$optionModel->delta_price.'<br>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="product-price fs20 fc-light-brown">
                                    <p><?= Yii::t('models/order', 'Price') ?></p>
                                    <?= $od->price.' '.Yii::t('models/cart', 'UAH') ?>
                                </div>
                                <?= $orderForm->field($od, '['.$index.']quantity')
                                              ->input('number') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <div class="col-lg-4 right-panel">
        <div class="panel panel-danger delivery-data">
            <p class="panel-heading"><?= Yii::t('models/order', 'Delivery data') ?></p>
            <div class="panel-body">
                <?= $orderForm->field($order->deliveryData, 'f_name') ?>
                <?= $orderForm->field($order->deliveryData, 'l_name') ?>
                <?= $orderForm->field($order->deliveryData, 'city') ?>
                <?= $orderForm->field($order->deliveryData, 'address') ?>
                <?= $orderForm->field($order->deliveryData, 'phone') ?>
                <?= $orderForm->field($order->deliveryData, 'email') ?>
            </div>
        </div>
        <div class="panel panel-info">
            <p class="panel-heading"><?= $order->order->getAttributeLabel('comment') ?></p>
            <div class="panel-body">
                <?= $orderForm->field($order->order, 'comment')
                              ->textarea()
                              ->label(false) ?>
            </div>
        </div>
    </div>
</div>
<?= Html::submitButton($order->order->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                       ['class' => $order->order->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>
