<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model common\models\DeliveryModel */

    $this->title = Yii::t('system/view', 'Create').' '.Yii::t('models/delivery', 'Delivery');
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('models', 'Delivery'),
        'url'   => ['index']
    ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
