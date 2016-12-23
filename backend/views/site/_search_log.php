<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\search\LogSearch */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="log-model-search">

    <?php $form = ActiveForm::begin([
                                        'action'  => ['index'],
                                        'method'  => 'get',
                                        'options' => [
                                            'data-pjax' => 1,
                                        ],
                                    ]); ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('system/view', 'Filter') ?></div>
        <div class="panel-body">
            <?= $form->field($model, 'id') ?>

            <?= $form->field($model, 'action') ?>

            <?= $form->field($model, 'action_data') ?>

            <?= $form->field($model, 'initializer') ?>

            <?= $form->field($model, 'user_id') ?>
        </div>
    </div>
    <div class="panel-footer">
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
