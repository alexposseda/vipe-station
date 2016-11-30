<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \backend\models\MainSettingShopModel
     */
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;

?>

<?php $form = ActiveForm::begin() ?>
    <div class="row">
        <?= $form->field($model, 'shopName')
                 ->textInput() ?>
        <?= $form->field($model, 'socialLink') ?>
        <?= $form->field($model, 'aboutAs')
                 ->textarea() ?>
        <?= $form->field($model, 'bannerLink')
                 ->textInput() ?>
        <?= $form->field($model, 'bannerText')
                 ->textarea() ?>
    </div>
<?= Html::submitButton('Сохранить'/*Yii::t('system', 'Сохранить')*/) ?>
<?php ActiveForm::end() ?>