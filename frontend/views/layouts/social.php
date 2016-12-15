<?php
    /**
     * @var $this \yii\web\View
     */
    use common\models\ShopSettingTable;
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;

?>

<div class="col s12 m12 l12 center-align">
    <?php
        $socialSetting = ShopSettingTable::getSettingValue('social');
        $socialSetting = (is_null($socialSetting)) ? [] : json_decode($socialSetting);
        foreach($socialSetting as $social):?>
            <a href="<?= Url::to($social->link) ?>"><img src="<?= FileManager::getInstance()
                                                                             ->getStorageUrl().$social->img ?>" alt="<?= $social->title ?>"></a>
        <?php endforeach; ?>
</div>
