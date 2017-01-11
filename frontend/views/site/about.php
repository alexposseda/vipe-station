<?php
    /**
     * @var $this \yii\web\View
     */
    use common\models\ShopSettingTable;

    $this->params['headerTitle'] = 'О нас';

    $shopAddresses = ShopSettingTable::getSettingValue('address');
    $markers = [];
    if(!empty($shopAddresses)){
        $shopAddresses = json_decode($shopAddresses);
        foreach($shopAddresses as $s_a){
            if($s_a->isGeneral == 1){
                $c = explode(';', $s_a->coordinates);
                $markers[] = [
                    'lat' => $c[0],
                    'lng' => $c[1]
                ];
            }
        }
        $markers = json_encode($markers);
    }
    if(is_null($shopAddresses)){
        $shopAddresses = [];
    }

    $this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyAUYPzaG4lQCw-v_7JUodo1mgWDlztuD0s',
                          ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('js/map.js', ['depends' => 'frontend\assets\AppAsset']);
    $js = <<<JS
mapInit();
var ms = {$markers};
for(var i = 0; i < ms.length; i++){
    addMarker(ms[i]);
}
JS;
    $this->registerJs($js, \yii\web\View::POS_END);

?>
<div class="col s12 page-main valign-wrapper">
    <div class="content valign">
        <div class="page-wrap">
            <div class="row page-wrap-content">
                <div class="mapBox" id="mapBox">
                    <div id="map"></div>
                </div>
                <div class="about-text row">
                    <div class="col l6 s12 fs20 about-content ">
                        <span class="delivery-title fs25 fc-orange">О нас</span>
                        <hr>
                        <?php if(!empty($aboutUs)){
                            echo nl2br($aboutUs);
                        } ?>
                    </div>
                    <div class="col l6 about-adress">
                        <span class="fs25 fc-orange">Адрес</span>
                        <hr>
                        <?php foreach($shopAddresses as $address): ?>
                            <span class="fs20 fc-dark-brown"><?= $address->address ?><br><?= nl2br($address->phones) ?>
                                <br><?= $address->schedule ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
