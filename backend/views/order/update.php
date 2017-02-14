<?php
    /**
     * @var $this  \yii\web\View
     * @var $order \common\models\forms\OrderForm
     */
    $this->title = Yii::t('system/view', 'Update').' '.Yii::t('models', 'Order').': '.$order->order->id;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Orders'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $order->order->id, 'url' => ['view', 'id' => $order->order->id]];
    $this->params['breadcrumbs'][] = Yii::t('system/view', 'Update');
?>
<?= $this->render('_form', ['order' => $order]) ?>
