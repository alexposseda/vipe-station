<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('models','Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('system/view', 'Create').' '.Yii::t('models/user', 'User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            // 'status',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'label'=>Yii::t('models', 'Role'),
                'content'=>function($data){

                    return current(Yii::$app->authManager->getRolesByUser($data->id))->name;
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
