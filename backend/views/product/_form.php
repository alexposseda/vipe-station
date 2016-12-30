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

    $this->registerJsFile('js/product_form.js', [
        'depends'  => '\backend\assets\AppAsset',
        'position' => \yii\web\View::POS_END
    ]);
?>

<div class="product-model-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $form->field($model, 'categories[]', ['options' => []])
                                     ->dropDownList($model->allCategories, [
                                         'multiple' => 'multiple',
                                         //                                 'prompt'   => Yii::t('system/view', 'Select').' '.Yii::t('models', 'Category'),
                                         'options'  => $model->categories,
                                         'data-url' => Url::to(['product/get-characteristics'])
                                     ]) ?>
                        </div>
                    </div><!--Categories-->
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $form->field($model->product, 'brand_id')
                                     ->dropDownList($model->getAllBrand(),
                                                    ['prompt' => Yii::t('system/view', 'Select').' '.Yii::t('models', 'Brand')]) ?>
                        </div>
                    </div><!--Brand-->
                </div>
            </div>
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
            <div class="row">
                <div class="col-lg-4 characteristic">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">Характеристики</p>
                        </div>
                        <div class="panel-body" id="characteristic-list">
                            <?php if(!empty($model->characteristics)): ?>
                                <?php foreach($model->characteristics as $char_m): ?>
                                    <?= $form->field($char_m, '['.$char_m->characteristic->id.']value')
                                             ->textInput()
                                             ->label($char_m->characteristic->title) ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info">Empty</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 option">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">Опции</p>
                        </div>
                        <div class="panel-body" id="characteristic-list">
                            <?php if(!empty($model->options)): ?>
                                <?php foreach($model->options as $opt_m): ?>
                                    <span class="option-label col-lg-12"><?= $opt_m->characteristic->title ?></span>
                                    <?= $form->field($opt_m, '['.$opt_m->characteristic->id.']value',
                                                     ['options' => ['class' => 'col-lg-4 form-inline']])
                                             ->textInput(['placeholder' => $opt_m->getAttributeLabel('value')])
                                             ->label(false) ?>
                                    <?= $form->field($opt_m, '['.$opt_m->characteristic->id.']delta_price',
                                                     ['options' => ['class' => 'col-lg-4 form-inline']])
                                             ->input('number', ['placeholder' => $opt_m->getAttributeLabel('delta_price')])
                                             ->label(false) ?>
                                    <?= $form->field($opt_m, '['.$opt_m->characteristic->id.']quantity',
                                                     ['options' => ['class' => 'col-lg-4 form-inline']])
                                             ->input('number', ['placeholder' => $opt_m->getAttributeLabel('quantity')])
                                             ->label(false) ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info">Empty</div>
                            <?php endif; ?>
                        </div>
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
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->product->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'), [
            'class' => $model->product->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'style' => 'width:100%'
        ]) ?>
    </div>


    <?php ActiveForm::end(); ?>
</div>

