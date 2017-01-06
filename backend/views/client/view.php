<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ClientModel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="client-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#info" data-toggle="tab"><?= Yii::t('models/client', 'Contact Information') ?></a>
        </li>
        <li><a href="#orders" data-toggle="tab"><?= Yii::t('models/client', 'History of orders') ?></a></li>
        <li><a href="#delivers" data-toggle="tab"><?= Yii::t('models/client', 'Shipping addresses') ?></a></li>
    </ul>
</div>

<div class="tab-content">
    <div class="client-view-info tab-pane active" id="info">
        <div class="row">
            <div class="col-lg-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/600px-No_image_available.svg.png"
                     style="width: 300px">
            </div>
            <div class="col-lg-4">
                <p><?= Yii::t('models/client', 'Edit personal data') ?></p>
                <div class="f_name">
                    <p><?= Yii::t('models/client', 'First name') ?></p>
                    <?= Html::encode($model->f_name) ?>
                </div>
                <div class="l_name">
                    <p><?= Yii::t('models/client', 'Last name') ?></p>
                    <?= Html::encode($model->l_name) ?>
                </div>
                <div class="phones">
                    <p><?= Yii::t('models/client', 'Phones') ?></p>
                    <?php
                    if (is_array($model->phones_arr)):
                        foreach ($model->phones_arr as $phone): ?>
                            <p><?= Html::encode($phone) ?></p>
                            <?php
                        endforeach;
                    endif; ?>

                </div>
                <div class="birthday">
                    <p><?= Yii::t('models/client', 'Birthday') ?></p>
                    <?= date('d.M.Y', $model->birthday) ?>
                </div>
                <div class="email">
                    <p><?= Yii::t('models/client', 'Email') ?></p>
                    <?= $model->email ?>
                </div>
            </div>
            <div class="col-lg-4">

            </div>
        </div>

        <?= Html::a(Yii::t('system/view', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('system/view', 'Request password reset'),
            ['request-password-reset', 'email' => $model->user->email, 'goback' => Url::to(['view', 'id' => $model->id])],
            ['class' => 'btn btn-danger']) ?>

    </div>
    <div class="client-orders tab-pane" id="orders">
        <h4><?= Yii::t('models/client', 'Your orders') ?></h4>
        <?php foreach ($model->orderClientDatas as $orderClientData): ?>
            <div class="row">
                <div class="col-lg-2">
                    <?= Html::a($orderClientData->order->id, ['order/view', 'id' => $orderClientData->order->id]) ?>
                    <?= date('d.M.Y', $orderClientData->order->created_at) ?>
                </div>
                <div class="col-lg-5">
                    наименования
                </div>
                <div class="col-lg-3">
                    количество
                </div>
                <div class="col-lg-2">
                    price
                </div>

            </div>
            <?= Yii::t('models/client', 'Total') ?> : <?= $orderClientData->order->total_cost ?>
        <?php endforeach; ?>
    </div>
    <div class="client-delivery tab-pane" id="delivers">
        Доставки
    </div>
</div>

