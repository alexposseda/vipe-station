<?php

    /**
     * @var $this yii\web\View
     * @var $bannerFile string
     * @var $bannerTitle string
     * @var $shopName string
     */

    use common\models\ShopSettingTable;

    $shopName = ShopSettingTable::getSettingValue('shopName');
    $banner = ShopSettingTable::getSettingValue('banner');
    if(!empty($banner)){
        $banner = json_decode($banner);
        $bannerTitle = $banner->bannerTitle;
        $bannerFile = \yii\alexposseda\fileManager\FileManager::getInstance()->getStorageUrl().substr($banner->bannerFile, 1);
    }
    $this->title = $shopName ? $shopName : Yii::$app->name;
    if (!empty($bannerFile)) {
        $css = <<<CSS
.section-title{
background:url("{$bannerFile}");
}
CSS;
        $this->registerCss($css);
    }
?>

<div class="col s12 section-title valign-wrapper">
    <div class="valign full-width">
        <span class="full-width center-align white-text urbanCircus"><?= $bannerTitle ?></span>
    </div>
</div>

