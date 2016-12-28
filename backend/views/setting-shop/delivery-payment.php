<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \backend\models\DeliverPayModel
     */
    use backend\widgets\FileManagerWidget\FileManagerWidget;
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;
    use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin() ?>
<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <p class="panel-title"><?= Yii::t('shop/setting', 'Deliver') ?></p>
            </div>
            <div class="panel-body">
                <div class="logo">
                    <?= Html::activeHiddenInput($model, 'logo[0]', ['id' => 'del-logo']) ?>
                    <?= FileManagerWidget::widget([
                                                      'uploadUrl'     => Url::to(['del-logo-upload']),
                                                      'removeUrl'     => Url::to(['del-logo-remove']),
                                                      'files'         => $model->logo[0],
                                                      'targetInputId' => 'del-logo',
                                                      'maxFiles'      => 1,
                                                      'title'         => $model->getAttributeLabel('logo')
                                                  ]) ?>
                </div>
                <?= $form->field($model, 'title[0]') ?>
                <?= $form->field($model, 'desc[0]')->textarea(['rows'=>6]) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <p class="panel-title"><?= Yii::t('shop/setting', 'Pay') ?></p>
            </div>
            <div class="panel-body">
                <div class="logo">
                    <?= Html::activeHiddenInput($model, 'logo[1]', ['id' => 'pay-logo']) ?>
                    <?= FileManagerWidget::widget([
                                                      'uploadUrl'     => Url::to(['pay-logo-upload']),
                                                      'removeUrl'     => Url::to(['pay-logo-remove']),
                                                      'files'         => $model->logo[1],
                                                      'targetInputId' => 'pay-logo',
                                                      'maxFiles'      => 1,
                                                      'title'         => $model->getAttributeLabel('logo')
                                                  ]) ?>
                </div>
                <?= $form->field($model, 'title[1]') ?>
                <?= $form->field($model, 'desc[1]')->textarea(['rows'=>6])  ?>
            </div>
        </div>
    </div>
</div>



<?= Html::submitButton(Yii::t('system', 'Save'), ['class'=>'btn btn-success']) ?>
<?php ActiveForm::end() ?>
