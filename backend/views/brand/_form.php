<?php

    use backend\widgets\FileManagerWidget\FileManagerWidget;
    use backend\widgets\LanguageWidget;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model backend\models\BrandForm */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= LanguageWidget::widget([
                            'form' => $form,
                            'model' => $model->brand,
                            'attributes' => [
                                    [
                                            'name' => 'title',
                                            'type' => 'textInput',
                                            'options' => ['maxlength' => true]
                                    ],
                                    [
                                            'name' => 'description',
                                            'type' => 'textarea',
                                            'options' => ['rows' => 6]
                                    ]
                            ]
                                                                ])?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading"><?= Yii::t('system/view', 'Seo') ?></div>
                <div class="panel-body">
                    <?= $form->field($model->seo, 'title')?>
                    <?= $form->field($model->seo, 'keywords')?>
                    <?= $form->field($model->seo, 'description')?>
                </div>
            </div>
            <?= Html::activeHiddenInput($model->brand, 'cover', ['id' => 'logo-input']) ?>
            <?= FileManagerWidget::widget([
                                              'uploadUrl'     => Url::to(['brand/upload-logo']),
                                              'removeUrl'     => Url::to(['brand/remove-logo']),
                                              'files'         => [],
                                              'maxFiles'      => 1,
                                              'title'         => Yii::t('models/brand', 'Logo'),
                                              'targetInputId' => 'logo-input'
                                          ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->brand->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                               ['class' => $model->brand->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>


</div>
