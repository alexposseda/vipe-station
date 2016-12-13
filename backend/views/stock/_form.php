<?php

    use backend\assets\StockFormAsset;
    use backend\widgets\FileManagerWidget\FileManagerWidget;
    use backend\widgets\LanguageWidget;
    use common\models\StockPolicyModel;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\View;
    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;

    /**
     * @var $this  yii\web\View
     * @var $model \backend\models\forms\StockForm
     * @var $form  yii\widgets\ActiveForm
     */

    StockFormAsset::register($this);
    if(!$model->stock->isNewRecord){
        $police_id = $model->stock->policy_id;
        $stock_value = $model->stock->stock_value;
        $stockInit = "initStockVal('$police_id','$stock_value');";
        $this->registerJs($stockInit, View::POS_END);
    }
?>

<div class="stock-model-form">

    <?php $form = ActiveForm::begin(['id' => 'stock-form']); ?>
    <?php Pjax::begin() ?>
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

                    <div id="stock-value-wrapper"></div>
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
                         ->checkboxList($model->getAllProducts(), [
                             'separator' => '<br>',
                             'item'      => function($index, $label, $name, $checked, $value) use ($model){
                                 if($model->stock->getProducts()
                                                 ->where(['id' => $value])
                                                 ->exists()
                                 ){
                                     $checked = !$checked;
                                 }

                                 return Html::checkbox($name, $checked, ['value' => $value, 'label' => $label]);
                             }
                         ]) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->stock->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                               ['class' => $model->stock->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'stock-sub']) ?>
    </div>
    <?php Pjax::end() ?>
    <?php ActiveForm::end(); ?>

</div>
