<?php

    use backend\widgets\FileManagerWidget\FileManagerWidget;
    use common\models\LanguageModel;
    use yii\bootstrap\Tabs;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;

    function getLanguageInputs($form, $model, $attributes){
        $items = [];
        /**
         * @var LanguageModel[]
         */
        $languages = LanguageModel::find()
                                  ->all();

        foreach($languages as $lang){
            $content = '';
            foreach($attributes as $attributeName => $fieldData){
                $content .= $form->field($model, $attributeName.'_'.$lang->code)->{$fieldData['type']}($fieldData['options']);
            }
            $items[] = [
                'label' => $lang->title,
                'content' => $content
            ];
        }

        return $items;
    }

    /* @var $this yii\web\View */
    /* @var $model backend\models\BrandForm */
    /* @var $form yii\widgets\ActiveForm */

?>

<div class="brand-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= Tabs::widget([
                                         'items' => getLanguageInputs($form, $model->brand, [
                                             'title'       => [
                                                 'type'    => 'textInput',
                                                 'options' => ['maxlength' => true]
                                             ],
                                             'description' => [
                                                 'type'    => 'textarea',
                                                 'options' => ['rows' => 6]
                                             ]
                                         ])
                                     ]); ?>
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
            </div>
            <?= Html::activeHiddenInput($model->brand, 'cover', ['id' => 'logo-input']) ?>
            <?= FileManagerWidget::widget([
                                              'uploadUrl'     => Url::to(['brand/upload-logo']),
                                              'removeUrl'     => Url::to(['brand/remove-logo']),
                                              'files'         => ($model->brand->isNewRecord) ? [] : $model->brand->cover,
                                              'maxFiles'      => 1,
                                              'title'         => Yii::t('models/brand', 'Logo'),
                                              'targetInputId' => 'logo-input'
                                          ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->brand->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'),
                               ['class' => $model->brand->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>


</div>
