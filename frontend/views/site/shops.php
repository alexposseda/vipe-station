<?php
    use common\models\ShopSettingTable;

    $this->params['headerTitle'] = 'Наши магазины';

    $shopAddresses = ShopSettingTable::getSettingValue('address');
    $markers = [];
    if(!empty($shopAddresses)){
        $shopAddresses = json_decode($shopAddresses);
        foreach($shopAddresses as $s_a){
                $c = explode(';', $s_a->coordinates);
                $markers[] = [
                    'lat' => $c[0],
                    'lng' => $c[1]
                ];
        }
        $markers = json_encode($markers);
    }
    $this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyAUYPzaG4lQCw-v_7JUodo1mgWDlztuD0s', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('js/map.js', ['depends' => 'frontend\assets\AppAsset']);
    $js = <<<JS
mapInit();
var ms = {$markers};
for(var i = 0; i < ms.length; i++){
    addMarker(ms[i]);
}
$('#mapWrapper').fullHeight(-290);
JS;
    $this->registerJs($js, \yii\web\View::POS_END);

?>
<div class="col s12 page-main valign-wrapper">
    <div class="content valign">
        <div class="page-wrap" id="mapWrapper">
            <div id="map"></div>
        </div>
    </div>
</div>
