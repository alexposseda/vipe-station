<?php
    $this->params['headerTitle'] = 'Доставка и Оплата';
?>
<div class="col s12 page-main valign-wrapper">
    <div class="content valign">
            <div class="row">
                <div class="col l6 valign">
                    <div class="delivery-wrap center-align">
                        <div class="delivery-img">
                            <img src="<?= \yii\alexposseda\fileManager\FileManager::getInstance()
                                                                                  ->getStorageUrl().json_decode($delivery->logo)[0] ?>">
                        </div>
                        <div class="delivery-content">
                            <span class="delivery-title fs20">Доставка</span>
                            <p><?= nl2br($delivery->desc) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col l6 valign">
                    <div class="delivery-wrap center-align">
                        <div class="delivery-img">
                            <img src="<?= \yii\alexposseda\fileManager\FileManager::getInstance()
                                                                                  ->getStorageUrl().json_decode($payment->logo)[0] ?>">
                        </div>
                        <div class="delivery-content">
                            <span class="delivery-title fs20">Оплата</span>
                            <p><?= nl2br($payment->desc) ?></p>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
