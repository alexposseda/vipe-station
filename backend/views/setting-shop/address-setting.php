<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \backend\models\forms\AddressSettingModel
     */
    use backend\assets\AddressFormAsset;
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;
    use yii\helpers\Url;

    AddressFormAsset::register($this);
    $markers = [];
    foreach($model->models as $index => $addressModel){
        if(!is_null($addressModel->coordinates)){
            $coords = explode(';', $addressModel->coordinates);
            $markers[$index] = [
                'lat' => $coords[0],
                'lng' => $coords[1]
            ];
        }
    }
    $markers = json_encode($markers);
    $js = <<<JS
function addAddress(){
    var addressBoxes = $('.address-box');
    var index = addressBoxes.last().data('index') + 1;
    var content = '<div class="panel panel-default"><div class="panel-heading"><p class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#address-box-'+index+'">Добавить магазин</a></p></div><div id="address-box-'+index+'" class="panel-collapse collapse in"><div class="panel-body address-box" data-index="'+index+'"><div class="form-group field-addressform-'+index+'-address required"><label class="control-label" for="addressform-'+index+'-address">Address</label><input type="text" id="addressform-'+index+'-address" class="form-control" name="AddressForm['+index+'][address]"><p class="help-block help-block-error"></p></div><div class="form-group field-addressform-'+index+'-schedule required"><label class="control-label" for="addressform-'+index+'-schedule">Schedule</label><textarea id="addressform-'+index+'-schedule" class="form-control" name="AddressForm['+index+'][schedule]" rows="4"></textarea><p class="help-block help-block-error"></p></div><div class="form-group field-addressform-'+index+'-phones required"><label class="control-label" for="addressform-'+index+'-phones">Phones</label><textarea id="addressform-'+index+'-phones" class="form-control" name="AddressForm['+index+'][phones]" rows="4"></textarea><p class="help-block help-block-error"></p></div><div class="form-group field-addressform-'+index+'-coordinates required"><label class="control-label" for="addressform-'+index+'-coordinates">Coordinates</label><input type="text" id="addressform-'+index+'-coordinates" class="form-control" name="AddressForm['+index+'][coordinates]" readonly><p class="help-block help-block-error"></p></div><div class="form-group field-addressform-'+index+'-isgeneral"><div class="checkbox"><label for="addressform-'+index+'-isgeneral"><input type="hidden" name="AddressForm['+index+'][isGeneral]" value="0"><input type="checkbox" id="addressform-'+index+'-isgeneral" name="AddressForm['+index+'][isGeneral]" value="1" disabled>General</label><p class="help-block help-block-error"></p></div></div</div></div></div>';
    
    $('#accordion').append(content);
    addMarker('addressform-'+index+'-coordinates','addressform-'+index+'-address');
    initAutocomplete('addressform-'+index+'-coordinates','addressform-'+index+'-address');
};

var markersData = {$markers};

mapInit();
if(markersData.length > 0){
    for(var i = 0; i < markersData.length; i++){
        addMarker('addressform-'+i+'-coordinates','addressform-'+i+'-address', markersData[i]);
        initAutocomplete('addressform-'+i+'-coordinates','addressform-'+i+'-address');
    }
}else{
    addMarker('addressform-0-coordinates','addressform-0-address');
    initAutocomplete('addressform-0-coordinates','addressform-0-address');
}

$('#add-btn').on('click', addAddress);
$('.del-address').on('click', function(){
   var self = $(this);
   $.post(self.data('url'), {}, function(){
        removeMarker('addressform-'+self.data('index')+'-coordinates');
        $('#address-'+self.data('index')).remove();
   })
});
$('.is-general').on('change', function(){
     if($('.is-general').is(':checked')){
        $('.is-general').not(this).attr('disabled', 'disabled');
     }else{
         $('.is-general').removeAttr('disabled');
     }
});

$(document).ready(function(){
    if($('.is-general').is(':checked')){
        $('.is-general').not(':checked').attr('disabled', 'disabled');
    }
});
JS;

    $this->registerJs($js, \yii\web\View::POS_END);
?>
<div class="row">
    <div class="col-md-5 col-lg-4">
        <?php $form = ActiveForm::begin(); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <p class="panel-title">Адреса</p>
            </div>
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                    <?php foreach($model->models as $index => $addressModel): ?>
                        <div class="panel panel-default" id="address-<?= $index ?>">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#address-box-<?= $index ?>">
                                        <?php if(count($model->models) > 0 and !empty($addressModel->address)): ?>
                                            <?= ($addressModel->isGeneral) ? 'Основной адрес' : 'Магазин '.$index ?>
                                        <?php else: ?>
                                            Добавить магазин
                                        <?php endif; ?>
                                    </a>
                                    <?php if(count($model->models) > 0 and !empty($addressModel->address)): ?>
                                        <button type="button" data-index="<?= $index ?>" data-url="<?= Url::to([
                                                                                                                   'setting-shop/delete-address',
                                                                                                                   'index' => $index
                                                                                                               ]) ?>"
                                                class="btn btn-danger del-address pull-right"><span
                                                    class="glyphicon glyphicon-remove"></span></button>
                                        <div class="clearfix"></div>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div id="address-box-<?= $index ?>"
                                 class="panel-collapse collapse <?= ($index == 0 and empty($addressModel->address)) ? 'in' : '' ?>">
                                <div class="panel-body address-box" data-index="<?= $index ?>">
                                    <?= $form->field($addressModel, '['.$index.']address') ?>
                                    <?= $form->field($addressModel, '['.$index.']schedule')
                                             ->textarea(['rows' => 4]) ?>
                                    <?= $form->field($addressModel, '['.$index.']phones')
                                             ->textarea(['rows' => 4]) ?>
                                    <?= $form->field($addressModel, '['.$index.']coordinates')
                                             ->textInput(['readonly' => true]) ?>
                                    <?= $form->field($addressModel, '['.$index.']isGeneral')
                                             ->checkbox([/*'disabled' => true,*/ 'class'=>'is-general']) ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="panel-footer text-right">
                <button type="button" class="btn btn-info" id="add-btn">Добавить Магазин</button>
                <?= Html::submitButton('Save', [
                    'class' => 'btn btn-success',
                    'id'    => 'save-btn'
                ]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-7 col-lg-8">
        <div class="panel panel-info">
            <div class="panel-heading">
                <p class="panel-title">Карта</p>
            </div>
            <div class="panel-body map">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
