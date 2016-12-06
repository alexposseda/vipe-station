<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    /* @var $this yii\web\View */
    /* @var $model backend\models\forms\CategoryForm */
    /* @var $form yii\widgets\ActiveForm */

//    var_dump($model->category->getErrors());
//    var_dump($model->seo->getErrors());

?>

<div class="category-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">

                    <?= $form->field($model->category, 'title')
                             ->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-group">
                    <?= Html::dropDownList('parent', $category_parent, $category_array, ['prompt' =>Yii::t('system/view','Select').' '. Yii::t('models/category', 'Category')]) ?>
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
                    <?= $form->field($model->seo, 'seo_block')?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->category->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                               ['class' => $model->category->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
