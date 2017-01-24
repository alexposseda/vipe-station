/**
 * Created by gektorgit on 12.12.16.
 */
$('button#add-delivery').click(function () {
    var index = $('.address-input').children('.form-inline').length;
    var html = '<div class="form-inline">' +
        '<div class="form-group field-deliveryaddressform-' + index + '-f_name required">' +
        '<input type="text" id="deliveryaddressform-' + index + '-f_name" class="form-control" name="DeliveryAddressForm[' + index + '][f_name]" placeholder="Имя">' +
        '<div class="help-block"></div>' +
        '</div>' +
        '<div class="form-group field-deliveryaddressform-' + index + '-l_name required">' +
        '<input type="text" id="deliveryaddressform-' + index + '-l_name" class="form-control" name="DeliveryAddressForm[' + index + '][l_name]" placeholder="Фамилия">' +
        '<div class="help-block"></div>' +
        '</div>' +
        '<div class="form-group field-deliveryaddressform-' + index + '-city required">' +
        '<input type="text" id="deliveryaddressform-' + index + '-city" class="form-control" name="DeliveryAddressForm[' + index + '][city]" placeholder="Город">' +
        '<div class="help-block"></div>' +
        '</div>' +
        '<div class="form-group field-deliveryaddressform-' + index + '-address required">' +
        '<input type="text" id="deliveryaddressform-' + index + '-address" class="form-control" name="DeliveryAddressForm[' + index + '][address]" placeholder="Адрес">' +
        '<div class="help-block"></div>' +
        '</div>' +
        '<div class="form-group field-deliveryaddressform-'+index+'-phone required">'+

        '<input type="text" id="deliveryaddressform-'+index+'-phone" class="form-control" name="DeliveryAddressForm['+index+'][phone]" data-plugin-inputmask="inputmask_c6d7b205">'+

        '<div class="help-block"></div>'+
        '</div>'+

        '<button type="button" class="btn btn-sm btn-danger del-delivery" data-index="' + index + '"><span class="glyphicon glyphicon-remove"></span></button>'
    '</div>';

    $('div.address-input').append(html);

    $('.del-delivery').on('click', deleteDelivery);

})
$('.del-delivery').on('click', deleteDelivery);
function deleteDelivery(){

    console.log($(this).parent());
    $(this).parent().remove();
}
