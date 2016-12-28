<?php

/**
 * @var $this yii\web\View
 * @var $bannerFile string
 * @var $bannerTitle string
 * @var $shopName string
 */

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
    <div class="valign-wrapper">
        <span class="left-align valign white-text urbanCircus"><?= $bannerTitle ?></span>
    </div>
</div>
