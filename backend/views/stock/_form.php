<?php

    use backend\widgets\FileManagerWidget\FileManagerWidget;
    use backend\widgets\LanguageWidget;
    use common\models\ProductModel;
    use common\models\StockPolicyModel;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;

    /**
     * @var $this  yii\web\View
     * @var $model \backend\models\forms\StockForm
     * @var $form  yii\widgets\ActiveForm
     */

?>

<div class="stock-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model->stock, 'policy_id')
                             ->dropDownList(ArrayHelper::map(StockPolicyModel::getAllPolicy(), 'id', 'name'),
                                            ['prompt' => Yii::t('system/view', 'Select').' '.Yii::t('models/stock', 'Policy')]) ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= LanguageWidget::widget([
                                                   'form'       => $form,
                                                   'model'      => $model->stock,
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
                        <div class="col-lg-3">
                            <?= $form->field($model->stock, 'date_start') ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model->stock, 'date_end') ?>
                        </div>
                    </div>

                    <?= $form->field($model->stock, 'stock_value') ?>

                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-4">
            <div class="stock-cover">
                <?= Html::activeHiddenInput($model->stock, 'cover', ['id' => 'logo-input']) ?>
                <?= FileManagerWidget::widget([
                                                  'uploadUrl'     => Url::to(['stock/upload-logo']),
                                                  'removeUrl'     => Url::to(['stock/remove-logo']),
                                                  'files'         => (!empty($model->stock->cover)) ? $model->stock->cover : [],
                                                  'maxFiles'      => 1,
                                                  'title'         => Yii::t('models/stock', 'Cover'),
                                                  'targetInputId' => 'logo-input'
                                              ]) ?>
            </div>
            <div class="stock-products">
                <?= $form->field($model, 'products')
                         ->checkboxList($model->getAllProducts(),['separator' => '<br>', 'item'=> function($index, $label, $name, $checked, $value) use ($model){
                             if(key_exists($value, $model->products)){
                                 return \yii\bootstrap\Html::checkbox($name, true, ['value' => $value]);
                             }else{
                                 return \yii\bootstrap\Html::checkbox($name, false, ['value' => $value]);
                             }
                             //todo go home

                         }]) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->stock->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                               ['class' => $model->stock->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
