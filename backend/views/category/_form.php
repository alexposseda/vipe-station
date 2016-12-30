<?php

    use backend\widgets\LanguageWidget;
    use backend\widgets\ProductWidget\ProductCharacteristicWidget;
    use backend\widgets\ProductWidget\ProductCharacteristicWidgetAsset;
    use yii\helpers\Html;
    use yii\helpers\Url;
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
    //
    //    ProductCharacteristicWidgetAsset::register($this);
    \backend\assets\CategoryFormAsset::register($this);
    $allCharacter = \common\models\CategoryModel::allCharacteristics($model->category->id);
?>

<div class="category-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">

            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
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
                            <?= $form->field($model->category, 'parent', [
                                'options' => [
                                    'data-url'     => Url::to([
                                                                  'category/get-characteristics-from-category'
                                                              ]),
                                    'data-current' => $model->category->parent0->id
                                ]
                            ])
                                     ->label('Родительская категория')
                                     ->dropDownList($model->getAllCategory(),
                                                    ['prompt' => Yii::t('system/view', 'Select').' '.Yii::t('models/category', 'Category')]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <p class="panel-title">Характеристики</p>
                        </div>
                        <div class="panel-body" id="character-list">

                            <?php foreach($allCharacter as $index => $characteristic) :
                                $label = false;
                                if($characteristic->isNewRecord){
                                    $label = 'Новая характеристика';
                                }
                                ?>
                                <div class="character-line" id="character-<?= $index ?>">
                                    <?php if($characteristic->category_id != $model->category->id): ?>
                                        <?= $form->field($characteristic, '['.$index.']title',
                                                         ['template' => '{label}<div class="row no-margin"><div class="col-lg-10 col-md-10 col-sm-9 ">{input}</div><div class="col-sm-3 col-md-2 col-lg-2"></div>{error}{hint}</div>'])
                                                 ->label($label)
                                                 ->textInput([
                                                                 'placeholder' => 'Название',
                                                                 'readonly'    => true
                                                             ]) ?>
                                        <?= Html::activeHiddenInput($characteristic, '['.$index.']id', ['value' => $characteristic->id]) ?>
                                    <?php else: ?>
                                        <?= $form->field($characteristic, '['.$index.']title',
                                                         ['template' => '{label}<div class="row no-margin"><div class="col-lg-10 col-md-10 col-sm-9 ">{input}</div><div class="col-sm-3 col-md-2 col-lg-2"><button type="button" data-url="'.Url::to(['category/del-characteristic', 'id'=>$characteristic->id]).'" class="btn btn-sm btn-danger del-character" data-index="'.$index.'"><span class="glyphicon glyphicon-remove"></span></button></div>{error}{hint}</div>'])
                                                 ->label($label)
                                                 ->textInput(['placeholder' => 'Название']) ?>
                                        <?= Html::activeHiddenInput($characteristic, '['.$index.']id', ['value' => $characteristic->id]) ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            <div id="parent-character-list">

                            </div>
                            <div id="new-character-list"></div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="button" class="btn btn-primary" id="add-character">Add Character</button>
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
                    <?= $form->field($model->seo, 'seo_block') ?>
                </div>
            </div>
        </div>
    </div>
    <?= Html::submitButton($model->category->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                           ['class' => $model->category->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>
