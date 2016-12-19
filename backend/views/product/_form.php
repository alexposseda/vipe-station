<?php

    use backend\widgets\FileManagerWidget\FileManagerWidget;
    use backend\widgets\LanguageWidget;
    use common\models\ProductCharacteristicItemModel;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model \backend\models\forms\ProductForm */
    /* @var $form yii\widgets\ActiveForm */

    var_dump($model->error);
?>

<div class="product-model-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model->product, 'brand_id')
                             ->dropDownList($model->getAllBrand(), ['prompt' => Yii::t('system/view', 'Select').' '.Yii::t('models', 'Brand')]) ?>
                </div>
            </div><!--Brand-->
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= LanguageWidget::widget([
                                                   'form'       => $form,
                                                   'model'      => $model->product,
                                                   'attributes' => [
                                                       [
                                                           'name'    => 'title',
                                                           'type'    => 'textInput',
                                                           'options' => ['maxlength' => true]
                                                       ],
                                                       [
                                                           'name'    => 'description',
                                                           'type'    => 'textarea',
                                                           'options' => ['rows' => 6]
                                                       ]
                                                   ]
                                               ]) ?>
                    <div class="row">
                        <?= $form->field($model->product, 'base_price', ['options' => ['class' => 'col-lg-6']])
                                 ->input('number') ?>

                        <?= $form->field($model->product, 'base_quantity', ['options' => ['class' => 'col-lg-6']])
                                 ->input('number') ?>
                    </div>
                </div>
            </div><!--Product attributes-->
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'categories[]')
                             ->dropDownList($model->allCategories, [
                                 'multiple' => 'multiple',
                                 //                                 'prompt'   => Yii::t('system/view', 'Select').' '.Yii::t('models', 'Category'),
                                 'options'  => $model->categories
                             ]) ?>
                </div>
            </div><!--Categories-->
            <div class="row">
                <div class="col-lg-6 characteristic">
                    <?php if(!empty($model->characteristics)): ?>
                        <?php foreach($model->characteristics as $char_m): ?>
                            <?= $form->field($char_m, '['.$char_m->characteristic->id.']value')
                                     ->textInput()
                                     ->label($char_m->characteristic->title) ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 option">
                    <?php if(!empty($model->options)): ?>
                        <?php foreach($model->options as $opt_m): ?>
                            <?= $form->field($opt_m, '['.$opt_m->characteristic->id.']value')
                                     ->textInput()
                                     ->label($opt_m->characteristic->title) ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
                </div>
            </div><!--Seo-->
            <?= Html::activeHiddenInput($model->product, 'gallery', ['id' => 'gallery-input']) ?>
            <?= FileManagerWidget::widget([
                                              'uploadUrl'     => Url::to(['product/upload-gallery']),
                                              'removeUrl'     => Url::to(['product/remove-gallery']),
                                              'files'         => $model->product->gallery ? $model->product->gallery : [],
                                              'maxFiles'      => 5,
                                              'title'         => Yii::t('models/product', 'Gallery'),
                                              'targetInputId' => 'gallery-input'
                                          ]) ?>
        </div><!--Seo & Gallery-->

        <div class="form-group">
            <?= Html::submitButton($model->product->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                                   ['class' => $model->product->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
