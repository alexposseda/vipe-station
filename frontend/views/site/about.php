<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('system/view', 'About as');
?>
<div class="col s12 page-main valign-wrapper">
    <div class="content valign">
        <div class="page-wrap">
            <div class="row page-wrap-content">
                <div class="mapBox">
                    <!--                    Карты нуждаются в реализации с помощью java script-->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2539.9823433814877!2d30.52011891610936!3d50.460053479476635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4ce46a355fd4f%3A0x9bb1b5375abbc47!2zR29vZ2xlINCj0LrRgNCw0ZfQvdCw!5e0!3m2!1suk!2sua!4v1478639386682"
                            height="300" frameborder="0" style="border:0" allowfullscreen></iframe>

                </div>


                <div class="about-text">
                    <div class="col l6 s12 fs20 about-content ">
                        <span class="delivery-title fs25 fc-orange"><?= Yii::t('shop/setting', 'About as') ?></span>

                        <p><?= $aboutUs ?></p>

                    </div>
                    <div class="col l6 about-adress">
                        <?php if (!empty($listAddress)): ?>
                            <?php for ($i = 0; $i < count($listAddress); $i++): ?>
                                <div class="address-item">
                                    <span class="fs25 fc-orange"><?= Yii::t('shop/setting', 'Address') ?></span><br>
                                    <span class="fs20 fc-dark-brown">
                                    <?= $listAddress[$i]['address'] ?><br>
                                        <?= Yii::t('models/client', 'Phones') . ': ' . $listAddress[$i]['phones'] ?><br>
                                        <?= Yii::t('shop/setting', 'schedule') . ': ' . $listAddress[$i]['schedule'] ?>
                                </span>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
