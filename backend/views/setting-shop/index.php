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
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;

    $this->registerJsFile('/js/setting.js', [
        'position' => \yii\web\View::POS_END,
        'depends'  => \backend\assets\AppAsset::className()
    ]);
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
                <?= $shopSettingForm->field($shopSettingModel, 'shopName')
                                    ->textInput(['disabled' => true]) ?>

            </div>
            <div class="panel-footer text-right">
                <button type="button" class="btn btn-warning"><?= Yii::t('system/view', 'Edit') ?></button>
                <?= Html::submitButton('Save', [
                    'class'    => 'btn btn-success hide',
                    'name'     => 'form',
                    'value'    => 'shopSetting',
                    'disabled' => true
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
                <div class="setting-data">
                    <?php if(!empty($bannerModel->bannerTitle)): ?>
                        <h2><?= $bannerModel->bannerTitle ?></h2>
                    <?php else: ?>
                        <div class="alert alert-info"><?= $bannerModel->getAttributeLabel('bannerTitle') ?> <?= Yii::t('system/view',
                                                                                                                       'Not set') ?></div>
                    <?php endif; ?>
                    <?php if(!empty($bannerModel->bannerFile)): ?>
                        <img src="<?= FileManager::getInstance()
                                                 ->getStorageUrl().$bannerModel->bannerFile ?>" class="img-responsive img-thumbnail">
                    <?php else: ?>
                        <div class="alert alert-info"><?= $bannerModel->getAttributeLabel('bannerFile') ?> <?= Yii::t('system/view',
                                                                                                                      'Not set') ?></div>
                    <?php endif; ?>
                </div>
                <div class="setting-form hide">
                    <?= $bannerForm->field($bannerModel, 'bannerTitle')
                                   ->textInput() ?>
                    <?= $bannerForm->field($bannerModel, 'bannerFile')
                                   ->fileInput() ?>
                </div>
            </div>
            <div class="panel-footer text-right">
                <button type="button" class="btn btn-warning"><?= Yii::t('system/view', 'Edit') ?></button>
                <?= Html::submitButton('Save', [
                    'class'    => 'btn btn-success hide',
                    'name'     => 'form',
                    'value'    => 'bannerSetting',
                    'disabled' => true
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
            <div class="panel-body" id="social-list">
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
                        <div class="row" id="soc-line-<?= $index?>">
                            <?php if(!empty($socialForm->title)): ?>
                                <div class="col-lg-1 text-center">
                                    <button type="button" data-index="<?= $index ?>" data-url="<?= Url::to([
                                                                                                               'setting-shop/delete-social',
                                                                                                               'index' => $index
                                                                                                           ]) ?>"
                                            class="btn btn-danger del-soc-but"><span
                                                class="glyphicon glyphicon-remove"></span></button>
                                </div>
                            <?php else: ?>
                                <div class="col-lg-1 text-center">

                                </div>
                            <?php endif; ?>
                            <?= $socialSettingForm->field($socialForm, '['.$index.']title', ['options' => ['class' => 'col-lg-4']])
                                                  ->textInput([
                                                                  'placeholder' => $socialForm->getAttributeLabel('title'),
                                                                  'disabled'    => true
                                                              ])
                                                  ->label(false) ?>
                            <?= $socialSettingForm->field($socialForm, '['.$index.']link', ['options' => ['class' => 'col-lg-5']])
                                                  ->input('url', [
                                                      'placeholder' => $socialForm->getAttributeLabel('link'),
                                                      'disabled'    => true
                                                  ])
                                                  ->label(false) ?>
                            <?= $socialSettingForm->field($socialForm, '['.$index.']iconFile', ['options' => ['class' => 'col-lg-2']])
                                                  ->fileInput([
                                                                  'class'    => 'hidden',
                                                                  'disabled' => true
                                                              ])
                                                  ->label($label['title'], $label['options']) ?>
                        </div>
                        <?php
                    endforeach;
                ?>
            </div>
            <div class="panel-footer text-right">
                <button type="button" class="btn btn-info hide" id="add-soc-but">Добавить социалку</button>
                <button type="button" class="btn btn-warning"><?= Yii::t('system/view', 'Edit') ?></button>
                <?= Html::submitButton('Save', [
                    'class'    => 'btn btn-success hide',
                    'name'     => 'form',
                    'value'    => 'socialSetting',
                    'disabled' => true
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
                              ->textarea([
                                             'rows'     => 6,
                                             'disabled' => true
                                         ]) ?>
            </div>
            <div class="panel-footer text-right">
                <button type="button" class="btn btn-warning"><?= Yii::t('system/view', 'Edit') ?></button>
                <?= Html::submitButton('Save', [
                    'class'    => 'btn btn-success hide',
                    'name'     => 'form',
                    'value'    => 'aboutSetting',
                    'disabled' => true
                ]) ?>
            </div>
        </div>
        <?php
            ActiveForm::end();
            Pjax::end();
        ?>
    </div>
</div>


