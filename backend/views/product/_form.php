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

    if(!$model->product->isNewRecord){
        $productList = [];
        $categories = [];
        foreach($model->product->categories as $c){
            $categories[] = $c->id;
        }
        $models = \common\models\ProductInCategoryModel::find()
                                                       ->where([
                                                                   'IN',
                                                                   'category_id',
                                                                   $categories
                                                               ])
                                                       ->all();
        foreach($models as $m){
            if($m->product->id == $model->product->id){
                continue;
            }
            $productList[$m->product->id] = $m->product->title;
        }
    }
?>

<div class="product-model-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-5">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php if($model->product->isNewRecord): ?>
                                <?= $form->field($model, 'categories[]', ['options' => ['class' => 'disabled']])
                                         ->dropDownList($model->allCategories, [
                                             'multiple'              => 'multiple',
                                             //                                 'prompt'   => Yii::t('system/view', 'Select').' '.Yii::t('models', 'Category'),
                                             'options'               => $model->categories,
                                             'data-getCharacter-url' => Url::to(['product/get-characteristics']),
                                             'data-getRelated-url'   => Url::to(['product/get-related-products']),
                                             'readonly'              => ($model->product->isNewRecord) ? false : true,
                                         ]) ?>
                            <?php else: ?>
                                <?php foreach($model->categories as $c_id => $other){
                                    echo Html::hiddenInput($model->formName().'[categories][]', $c_id);
                                } ?>
                                <div class="form-group">
                                    <label for="s1" class="control-label">Категории</label>
                                    <?= Html::dropDownList('', array_keys($model->categories), $model->allCategories, [
                                        'class'    => 'form-control',
                                        'multiple' => 'multiple',
                                        'disabled' => true,
                                        'id'       => 's1'
                                    ]) ?>
                                </div>
                            <?php endif; ?>
                            <?= $form->field($model->product, 'brand_id')
                                     ->dropDownList($model->getAllBrand(),
                                                    ['prompt' => Yii::t('system/view', 'Select').' '.Yii::t('models', 'Brand')]) ?>
                        </div>
                    </div><!--Categories-->
                </div>
                <div class="col-sm-12 col-md-6 col-lg-7">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <?= $form->field($model->product, 'base_price', ['options' => ['class' => 'col-lg-6']])
                                         ->input('number') ?>

                                <?= $form->field($model->product, 'base_quantity', ['options' => ['class' => 'col-lg-6']])
                                         ->input('number') ?>
                            </div>
                        </div>
                    </div><!--Brand-->
                    <div class="panel panel-info">
                        <div class="panel-heading"><p class="panel-title">Связанные продукты</p></div>
                        <div class="panel-body">
                            <?php if(!$model->product->isNewRecord): ?>
                                <?= $form->field($model, 'related_products[]')
                                         ->dropDownList($productList, [
                                             'multiple' => 'multiple',
                                             'options'  => $model->allRelatedProducts,
                                             'disabled' => ($model->product->isRelatedProduct()) ? true : false,
                                         ]) ?>
                            <?php else: ?>
                                <div class="alert alert-info" id="related-alert">Select the category!</div>
                            <?php endif; ?>
                            <div id="related"></div>

                        </div>
                    </div>
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

                </div>
            </div><!--Product attributes-->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title">Характеристики</p>
                </div>
                <div class="panel-body" id="characteristic-list">
                    <?php if(!empty($model->characteristics)): ?>
                        <?php foreach($model->characteristics as $index => $char_m): ?>
                            <?= $form->field($char_m, '['.$char_m->characteristic->id.']value',
                                             ['options' => ['class' => 'col-sm-12 col-md-6 col-lg-4']])
                                     ->textInput()
                                     ->label($char_m->characteristic->title) ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info">Empty</div>
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
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->product->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'), [
            'class' => $model->product->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'style' => 'width:100%'
        ]) ?>
    </div>


    <?php ActiveForm::end(); ?>
</div>
