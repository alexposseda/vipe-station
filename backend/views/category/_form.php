<?php

    use backend\widgets\ProductCharacteristicWidget\ProductCharacteristicWidget;
    use backend\widgets\ProductCharacteristicWidget\ProductCharacteristicWidgetAsset;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model backend\models\forms\CategoryForm */
    /* @var $form yii\widgets\ActiveForm */
    ProductCharacteristicWidgetAsset::register($this);
?>

<div class="category-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">

                    <?= $form->field($model->category, 'title')
                             ->textInput(['maxlength' => true]) ?>
                    <?= Html::activeDropDownList($model->category, 'parent', $category_array,
                                                 ['prompt' => Yii::t('system/view', 'Select').' '.Yii::t('models/category', 'Category')]) ?>

                    <div class="panel-body">
                        <?= Html::submitButton($model->category->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                                               ['class' => $model->category->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-9 col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading"><?= Yii::t('system/view', 'Seo') ?></div>
                <div class="panel-body">
                    <?= $form->field($model->seo, 'title') ?>
                    <?= $form->field($model->seo, 'keywords') ?>
                    <?= $form->field($model->seo, 'description') ?>
                    <?= $form->field($model->seo, 'seo_block') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-success">
                <div class="panel-heading"><?= 'Product Characteristic' ?></div>
                <div class="panel-body product-characteristic">
                    <?= ProductCharacteristicWidget::widget([
                                                                'id' => $model->category->id,
                                                            ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-2">
            <div class="panel panel-success">
                <div class="panel-body">
                    <?= Html::button(Yii::t('system/view', 'Create').' '.Yii::t('models/characteristic', 'Characteristic')) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-2">
            <div class="panel panel-success">
                <div class="panel-body add-characteristic">
                    <?= Html::textInput('characteristic', null) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
