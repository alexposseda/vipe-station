<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-model-search">

    <?php $form = ActiveForm::begin([
                                        'action' => ['index'],
                                        'method' => 'get',
                                        'options' => [
                                            'data-pjax' => 1,
                                        ],
    ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('system/view','Filter')?></div>
        <div class="panel-body">
            <?= $form->field($model, 'id') ?>
            <?= $form->field($model, 'name') ?>
        </div>
    </div>

    <div class="panel-footer">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('system/view','Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a( Yii::t( 'system/view', 'Reset' ), $form->action, [ 'class' => 'btn btn-default' ] ) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
