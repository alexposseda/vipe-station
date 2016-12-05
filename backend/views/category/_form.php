<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\CategoryModel */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="category-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">

                    <?= $form->field($model, 'title')
                             ->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'parent')
                             ->textInput() ?>

                    <?= $form->field($model, 'slug')
                             ->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'seo_id')
                             ->textInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                                               ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
