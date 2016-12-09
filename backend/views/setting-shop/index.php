<?php
    /**
     * @var $this                \yii\web\View
     * @var $model               \backend\models\MainSettingShopModel
     * @var $shopSettingModel    \backend\models\forms\ShopSettingForm
     * @var $socialSettingModel  \backend\models\forms\SocialModel
     * @var $bannerModel         \backend\models\forms\BannerForm
     * @var $aboutUsModel        \backend\models\forms\AboutUsForm
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\bootstrap\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;

?>
<h1><?= Yii::t('system/view', 'General Setting') ?></h1>
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-4">
        <?php
            Pjax::begin();
            $shopSettingForm = ActiveForm::begin();
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">Shop Settings</div>
            <div class="panel-body">
                <?= $shopSettingForm->field($shopSettingModel, 'shopName') ?>

            </div>
            <div class="panel-footer text-right">
                <?= Html::submitButton('Save', [
                    'class' => 'btn btn-success',
                    'name'  => 'form',
                    'value' => 'shopSetting'
                ]) ?>
            </div>
        </div>
        <?php
            ActiveForm::end();
            Pjax::end();
        ?>

        <?php
            Pjax::begin();
            $bannerForm = ActiveForm::begin();
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">Banner setting</div>
            <div class="panel-body">
                <?= $bannerForm->field($bannerModel, 'bannerTitle') ?>
                <?= $bannerForm->field($bannerModel, 'bannerFile')
                               ->fileInput() ?>
            </div>
            <div class="panel-footer text-right">
                <?= Html::submitButton('Save', [
                    'class' => 'btn btn-success',
                    'name'  => 'form',
                    'value' => 'bannerSetting'
                ]) ?>
            </div>
        </div>
        <?php
            ActiveForm::end();
            Pjax::end();
        ?>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-8">
        <?php
            Pjax::begin();
            $socialSettingForm = ActiveForm::begin();
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">Social Links</div>
            <div class="panel-body">
                <?php
                    foreach($socialSettingModel->socialForms as $index => $socialForm):
                        if(empty($socialForm->icon)){
                            $label = [
                                'title'   => '<span class="glyphicon glyphicon-plus"></span>',
                                'options' => ['class' => 'btn btn-success'],
                            ];
                        }else{
                            $label = [
                                'title'   => Html::img(FileManager::getInstance()
                                                                  ->getStorageUrl().$socialForm->icon, ['class' => 'social-icon']),
                                'options' => ['class' => 'btn btn-default no-pad'],
                            ];
                        }

                        $label['options']['style'] = 'width: 100%';

                        ?>
                        <div class="row">
                            <div class="col-lg-1 text-center">
                                <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                            <?= $socialSettingForm->field($socialForm, '['.$index.']title', ['options' => ['class' => 'col-lg-4']])
                                                  ->textInput(['placeholder' => $socialForm->getAttributeLabel('title')])
                                                  ->label(false) ?>
                            <?= $socialSettingForm->field($socialForm, '['.$index.']link', ['options' => ['class' => 'col-lg-5']])
                                                  ->input('url', ['placeholder' => $socialForm->getAttributeLabel('link')])
                                                  ->label(false) ?>
                            <?= $socialSettingForm->field($socialForm, '['.$index.']iconFile', ['options' => ['class' => 'col-lg-2']])
                                                  ->fileInput(['class' => 'hidden'])
                                                  ->label($label['title'], $label['options']) ?>
                        </div>
                        <?php
                    endforeach;
                ?>
            </div>
            <div class="panel-footer text-right">
                <button type="button" class="btn btn-info">Add Social</button>
                <?= Html::submitButton('Save', [
                    'class' => 'btn btn-success',
                    'name'  => 'form',
                    'value' => 'socialSetting'
                ]) ?>
            </div>
        </div>
        <?php
            ActiveForm::end();
            Pjax::end();
        ?>

        <?php
            Pjax::begin();
            $aboutForm = ActiveForm::begin();
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">About us</div>
            <div class="panel-body">
                <?= $aboutForm->field($aboutUsModel, 'about')
                              ->textarea(['rows' => 6]) ?>
            </div>
            <div class="panel-footer text-right">
                <?= Html::submitButton('Save', [
                    'class' => 'btn btn-success',
                    'name'  => 'form',
                    'value' => 'aboutSetting'
                ]) ?>
            </div>
        </div>
        <?php
            ActiveForm::end();
            Pjax::end();
        ?>
    </div>
</div>


