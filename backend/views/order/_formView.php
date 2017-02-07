<?php
    /**
     * @var $this  \yii\web\View
     * @var $order \common\models\forms\OrderForm
     * @var $od \common\models\OrderDataModel
     */
    use common\models\ClientModel;
    use common\models\OrderModel;
    use common\models\ProductCharacteristicItemModel;
    use common\models\ProductOptionModel;
    use yii\bootstrap\ActiveForm;
    use yii\caching\DbDependency;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\View;
    $url = Url::to(['client/get-client-data']);
?>

<div class="row">
    <div class="col-lg-8 left-panel">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <label class="control-label" for="payment_id"><?= Yii::t('system/view', 'Payment')?></label>
                <input class="form-control" type="text" id="payment_id" readonly="readonly" value="<?= Html::encode($order->order->payment->name) ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <label class="control-label" for="delivery_id"><?= Yii::t('system/view', 'Delivery')?></label>
                <input class="form-control" type="text" id="delivery_id" readonly="readonly" value="<?= Html::encode($order->order->delivery->name) ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <label class="control-label" for="status"><?= Yii::t('models/user', 'Status')?></label>
                <input class="form-control" type="text" id="status" readonly="readonly" value="<?= Html::encode($order->order->status) ?>">
            </div>
        </div>
        <div class="panel panel-default order-detail">
            <p class="panel-heading"><?= Yii::t('models/order', 'Order Data') ?></p>
            <div class="row">
                <?php if ($order->orderData): ?>
                    <?php
                    foreach ($order->orderData as $index => $od): ?>
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

                                <div class="product-price fs20 fc-light-brown">
                                    <p><?= Yii::t('models/order', 'Price') ?></p>
                                    <?= $od->price . ' ' . Yii::t('models/cart', 'UAH') ?>
                                </div>
                                <div class="product-quantity fs20 fc-orange">
                                    <?= Html::encode($od->quantity) ?>
                                </div>
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
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <label class="control-label" for="client_id"><?= Yii::t('models', 'Client')?></label>
                        <input class="form-control" type="text" id="client_id" readonly="readonly" value="<?= Html::encode($order->client->name) ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <label class="control-label" for="fname_id"><?= Yii::t('models/client', 'First name')?></label>
                        <input class="form-control" type="text" id="fname_id" readonly="readonly" value="<?= Html::encode($order->deliveryData->f_name) ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <label class="control-label" for="lname_id"><?= Yii::t('models/client', 'Last name')?></label>
                        <input class="form-control" type="text" id="lname_id" readonly="readonly" value="<?= Html::encode($order->deliveryData->l_name) ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <label class="control-label" for="city_id"><?= Yii::t('models/client', 'City')?></label>
                        <input class="form-control" type="text" id="city_id" readonly="readonly" value="<?= Html::encode($order->deliveryData->city) ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <label class="control-label" for="address_id"><?= Yii::t('models/client', 'Address')?></label>
                        <input class="form-control" type="text" id="address_id" readonly="readonly" value="<?= Html::encode($order->deliveryData->address) ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <label class="control-label" for="phone_id"><?= Yii::t('models/client', 'Phone')?></label>
                        <input class="form-control" type="text" id="phone_id" readonly="readonly" value="<?= Html::encode($order->deliveryData->phone) ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <label class="control-label" for="email_id"><?= Yii::t('models/client', 'Email')?></label>
                        <input class="form-control" type="text" id="email_id" readonly="readonly" value="<?= Html::encode($order->deliveryData->email) ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-info">
            <p class="panel-heading"><?= $order->order->getAttributeLabel('comment') ?></p>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <label class="control-label" for="email_id"><?= Yii::t('models/client', 'Comment')?></label>
                        <textarea class="form-control" type="" id="email_id" readonly="readonly" ><?= Html::encode($order->order->comment) ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<p>
    <?= Html::a(Yii::t('system/view', 'Update').' '.Yii::t('models', 'Order'), [
        'update',
        'id' => $order->order->id
    ], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('system/view', 'Delete').' '.Yii::t('models', 'Order'), [
        'delete',
        'id' => $order->order->id
    ], [
                    'class' => 'btn btn-danger',
                    'data'  => [
                        'confirm' => Yii::t('system/view', 'Are you sure you want to delete this item?'),
                        'method'  => 'post',
                    ],
                ]) ?>
</p>
