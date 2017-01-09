<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\BrandModel
     */

    use yii\helpers\Html;
    use yii\helpers\Url;

?>
<div class="wrap-items">
    <div class="wrap-items-first-section left center-align">
        <div class="product-img">
            <img src="<?= (empty($model->cover)) ? Url::to('/images/noPicture.png', true) : \yii\alexposseda\fileManager\FileManager::getInstance()->getStorageUrl().$model->cover?>" alt="<?= $model->title?>" class="">
        </div>
        <div class="wrap-text-block">
            <div class="product-title fs20 fc-orange"><?= $model->title?></div>
            <!--<span class="block-bottom"></span>-->
        </div>

    </div>
    <div class="wrap-items-second-section left">
        <div class="product-title">
            <a href="<?= Url::to(['catalog/brand', 'slug' => $model->slug])?>" class="fs20 fc-orange"><?= $model->title?></a></div>

        <div class="product-description fs15 fc-dark-brown"><p><?= nl2br($model->description)?></p></div>
        <div class="btn-buy center-align fs15 fc">
            <a href="<?= Url::to(['catalog/brand', 'slug' => $model->slug])?>">Перейти</a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
