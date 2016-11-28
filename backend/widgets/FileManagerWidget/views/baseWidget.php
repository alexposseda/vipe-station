<?php
    use yii\alexposseda\fileManager\FileManager;

    /**
     * @var array $notSavedFiles
     * @var array $savedFiles
     */

?>
<div class="fmw-container panel panel-default" id="<?= $widgetId?>">
    <div class="panel-heading"><?= $title?></div>
    <div class="panel-body fmw-content">
        <?php
            if(!empty($notSavedFiles)):
                ?>
                <div class="panel panel-danger fmw-notsaved">
                    <div class="panel-heading"><?= Yii::t('FileManagerWidget', 'Not Saved Files')?></div>
                    <div class="panel-body">
                        <div class="row fmw-notsaved-gallery">
                            <?php foreach($notSavedFiles as $file): ?>
                                <div class="col-lg-6 fmw-notsaved-item">
                                    <img src="<?= FileManager::getInstance()->getStorageUrl().$file ?>">
                                    <div class="fmw-actions">
                                        <button type="button" class="btn btn-danger fmw-removeBtn" data-path="<?= $file ?>">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                        <button type="button" class="btn btn-success fmw-replaceBtn" data-path="<?= $file ?>">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php
            endif;
        ?>
        <div class="fmw-messageBox" id="<?= $widgetId?>-messageBox">
            <?php if(empty($savedFiles)): ?>
                <div class="fmw-message alert alert-info"><?= Yii::t('FileManagerWidget', 'Not found any file')?></div>
            <?php endif; ?>
        </div>
        <div class="fmw-galleryBox row" id="<?= $widgetId?>-galleryBox">
            <?php
                if(!empty($savedFiles)):
                    foreach($savedFiles as $file):
                        ?>
                        <div class="col-lg-6 fmw-galleryBox-item">
                            <img src="<?= FileManager::getInstance()->getStorageUrl().$file?>">
                            <div class="fmw-actions">
                                <button type="button" class="btn btn-warning fmw-removeBtn" data-path="<?= $file?>">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endif;
            ?>
        </div>
        <div class="fmw-preloader" id="<?= $widgetId?>-preloader">
            <span>Loading....</span>
        </div>
    </div>
    <div class="panel-footer">
        <div class="form-group fmw-input">
            <input type="file" name="<?= FileManager::getInstance()->getAttributeName()?>" class="form-control" id="<?= $widgetId?>-input" placeholder="<?= Yii::t('FileManagerWidget', 'Choose file')?>">

        </div>
    </div>
</div>
