<?php

    use backend\widgets\LanguageWidget;
    use backend\widgets\ProductWidget\ProductCharacteristicWidget;
    use backend\widgets\ProductWidget\ProductCharacteristicWidgetAsset;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\ProductCharacteristicModel;

    /**
     * @var                               $this  yii\web\View
     * @var                               $model backend\models\forms\CategoryForm
     * @var                               $form  yii\widgets\ActiveForm
     * @var ProductCharacteristicModel [] $characteristics
     * <div class="panel panel-success">
     * <div class="panel-heading"><?= Yii::t('models', 'Characteristics').' '.Yii::t('models/product', 'Product') ?></div>
     * <div class="panel-body product-characteristic">
     * <?= ProductCharacteristicWidget::widget([
     * 'id' => $model->category->id,
     * ]) ?>
     * </div>
     * </div>
     */

    ProductCharacteristicWidgetAsset::register($this);
?>

<div class="category-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= LanguageWidget::widget([
                                                   'form'       => $form,
                                                   'model'      => $model->category,
                                                   'attributes' => [
                                                       [
                                                           'name'    => 'title',
                                                           'type'    => 'textInput',
                                                           'options' => ['maxlength' => true]
                                                       ]
                                                   ]
                                               ]) ?>
                    <?= $form->field($model->category, 'parent')
                             ->dropDownList($model->getAllCategory(),
                                            ['prompt' => Yii::t('system/view', 'Select').' '.Yii::t('models/category', 'Category')]) ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-body">
                    <?= Html::tag('span', Yii::t('models/category', 'Parent Characteristics'),
                                  ['class' => 'panel panel-success panel-heading']) ?>
                    <?php foreach($model->parentCharacteristics as $index => $parentcharacteristic) : ?>
                        <?= $form->field($parentcharacteristic, '['.$index.']title') ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-body">
                    <?= Html::tag('span', Yii::t('system/view', 'Create').' '.Yii::t('models/characteristic', 'Characteristic'),
                                  ['class' => 'btn btn-primary']) ?>
                    <?php foreach($model->characteristics as $index => $characteristic) : ?>
                        <?= $form->field($characteristic, '['.$index.']title') ?>
                        <?= $form->field($characteristic, '['.$index.']id')
                                 ->hiddenInput(['value' => $characteristic->id])
                                 ->label(false) ?>
                    <?php endforeach; ?>
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
    <div class="panel-body">
        <?= Html::submitButton($model->category->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                               ['class' => $model->category->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
