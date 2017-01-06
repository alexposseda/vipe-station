/**
 * Created by gektorgit on 12.12.16.
 */
$('button.add-delivery').click(function () {
    var index = $('.address-input').children('.form-inline').length;
    var html = '<div class="form-inline">' +
        '<div class="form-group field-clientmodel-delivery_data-' + index + '-f_name has-success">' +
        '<input type="text" id="clientmodel-delivery_data-' + index + '-f_name" class="form-control" name="ClientModel[delivery_data][' + index + '][f_name]" placeholder="Имя">' +
        '<div class="help-block"></div>' +
        '</div>' +
        '<div class="form-group field-clientmodel-delivery_data-' + index + '-l_name">' +
        '<input type="text" id="clientmodel-delivery_data-' + index + '-l_name" class="form-control" name="ClientModel[delivery_data][' + index + '][l_name]" placeholder="Фамилия">' +
        '<div class="help-block"></div>' +
        '</div>' +
        '<div class="form-group field-clientmodel-delivery_data-' + index + '-city">' +
        '<input type="text" id="clientmodel-delivery_data-' + index + '-city" class="form-control" name="ClientModel[delivery_data][' + index + '][city]" placeholder="Город">' +
        '<div class="help-block"></div>' +
        '</div>' +
        '<div class="form-group field-clientmodel-delivery_data-' + index + '-address">' +
        '<input type="text" id="clientmodel-delivery_data-' + index + '-address" class="form-control" name="ClientModel[delivery_data][' + index + '][address]" placeholder="Адрес">' +
        '<div class="help-block"></div>' +
        '</div>' +
        '<div class="form-group field-clientmodel-delivery_data-' + index + '-phone">' +
        '<input type="text" id="clientmodel-delivery_data-' + index + '-phone" class="form-control" name="ClientModel[delivery_data][' + index + '][phone]" placeholder="Телефон">' +
        '<div class="help-block"></div>' +
        '</div>' +
        '</div>';

    $('div.address-input').parent().append(html);
    alert("Hello");
    // var delivery_data = '{
    // "firstName": $('input[name="firstName"]').val(),
    //     'lastName' = $('input[name="lastName"]').val();
    // var city = $('input[name="city"]').val();
    // var address = $('input[name="address"]').val();
    // var phone = $('input[name="phone"]').val();
    // }';

    $('#clientmodel-delivery_data').val();

})
;
