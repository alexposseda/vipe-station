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

    <ul class="nav nav-pills">
        <li><a href="#"><?= Yii::t('models/client', 'Contact Information') ?></a></li>
        <li><a href="#"><?= Yii::t('models/client', 'History of orders') ?></a></li>
        <li><a href="#"><?= Yii::t('models/client', 'Shipping addresses') ?></a></li>
    </ul>
</div>

<div class="client-view">
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
                <?php foreach($model->phones_arr as $phone): ?>
                    <p><?= Html::encode($phone) ?></p>
                <?php endforeach; ?>
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
    <?php // DetailView::widget([
        //                               'model'      => $model,
        //                               'attributes' => [
        //                                   'id',
        //                                   'user_id',
        //                                   'name',
        //                                   'phones',
        //                                   'birthday',
        //                                   'delivery_data:ntext',
        //                                   'created_at',
        //                                   'updated_at',
        //                               ],
        //                           ]) ?>

    <?= Html::a(Yii::t('system/view', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('system/view', 'Request password reset'),
                ['request-password-reset', 'email' => $model->user->email, 'goback' => Url::to(['view', 'id' => $model->id])],
                ['class' => 'btn btn-danger']) ?>

</div>

