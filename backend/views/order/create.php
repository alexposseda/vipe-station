<?php
    /**
     * @var $this  \yii\web\View
     * @var $order \common\models\OrderModel
     */
    $this->title = Yii::t('system/view', 'Create').' '.Yii::t('models', 'Order');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Orders'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['order' => $order]) ?>
