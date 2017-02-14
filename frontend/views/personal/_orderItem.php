<?php
	/**
	 * @var $this  \yii\web\View
	 * @var $model \common\models\OrderClientDataModel
	 */

?>
<li class="col l3 m4 fs15 fc-brown">
    <span>#<?= $model->order->id ?></span><br>
    <span><?= date( 'F', $model->order->created_at ) ?> <br><?= date( 'd.m.y', $model->order->created_at ) ?> <br><?= date( 'H:i',
	                                                                                                                        $model->order->created_at ) ?></span>
</li>
<li class="col l3 m4">
    <span class="fs15 fc-brown"><?= $model->order->getDeliveryData()->address ?></span><br>
    <span class="fs15 fc-brown"><?= $model->order->delivery->name ?></span><br>
    <span class="fs15 fc-brown"><?= $model->order->payment->name ?></span><br>
</li>
<li class="col l3 m3 fs15">
</li>
<li class="col l3 m12 right-align">
    <span class="fc-dark-brown fs20"><?= $model->order->getOrderDatas()
                                                      ->sum( 'price*quantity' ) ?> uah</span><br>
    <span class="fc-dark-brown fs15">Доставка</span>
    <span class="fc-dark-brown fs15"><?= $model->order->delivery->price ?></span><br>
    <span class="fc-orange fs20">Итог</span>
    <span class="fc-orange fs20"><?= $model->order->total_cost ?> uah</span>
</li>
