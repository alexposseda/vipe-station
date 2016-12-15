<?php
    /* @var $this yii\web\View */
    $this->title = Yii::t('shop/setting', 'Shipping and payment');
?>
<div class="col s12 page-main valign-wrapper">
    <div class="content valign">
        <div class="row">
            <div class="col l6 m10 push-m1">
                <div class="delivery-wrap center-align">
                    <div class="delivery-wrap-content">
                        <?php if(!empty($listDelivery)) :?>
                        <div class="delivery-img">
                            <img src="<?=$listDelivery['logo']?>"><br>
                        </div>
                        <div class="delivery-content">
                            <span class="delivery-title fs30 fc-orange"><?=$listDelivery['title']?></span>
                            <p class="fc20 fc-dark-brown left-align"><?=$listDelivery['desc']?></p>
                            <hr class="hide-on-med-and-down">
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="col l6 m10 push-m1">
                <div class="delivery-wrap center-align">
                    <div class="delivery-wrap-content">
                        <?php if(!empty($listPayment)) :?>
                        <div class="delivery-img">
                            <img src="<?=$listPayment['logo']?>"><br>
                        </div>
                        <div class="delivery-content">
                            <span class="delivery-title fs30 fc-orange"><?=$listPayment['title']?></span>
                            <p class="fc20 fc-dark-brown left-align"><?=$listPayment['desc']?> </p>
                            <hr class="hide-on-med-and-down">
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
