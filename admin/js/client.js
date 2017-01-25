/**
 * Created by gektorgit on 12.12.16.
 */
$('button#add-delivery').click(function () {
    var index = $('.address-input').children('.form-inline').length;
    var html = '<div class="form-inline" id="form1">' +
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
        '<div class="form-group field-deliveryaddressform-' + index + '-phone required">' +

        '<input type="text" id="deliveryaddressform-' + index + '-phone" class="form-control" name="DeliveryAddressForm[' + index + '][phone]" data-plugin-inputmask="inputmask_c6d7b205">' +

        '<div class="help-block"></div>' +
        '</div>' +

        '<button type="button" class="btn btn-sm btn-danger del-delivery" data-index="' + index + '"><span class="glyphicon glyphicon-remove"></span></button>'
    '</div>';

    $('div.address-input').append(html);

    //$('#client_form').yiiActiveForm('validate', true);

        var inputmask_c6d7b205 = {"mask": "(999)999-99-99"};
        $("#deliveryaddressform-[index]-phone").inputmask(inputmask_c6d7b205);
        $('#client_form').yiiActiveForm([{
            "id": 'deliveryaddressform-' + index + '-f_name',
            "name": '[' + index + ']f_name',
            "container": '.field-deliveryaddressform-' + index + '-f_name',
            "input": '#deliveryaddressform-' + index + '-f_name',
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {"message": "Необходимо заполнить «Имя»."});
                yii.validation.string(value, messages, {"message": "Значение «Имя» должно быть строкой.", "skipOnEmpty": 1});
            }
        }, {
            "id": 'deliveryaddressform-' + index + '-l_name',
            "name": '[' + index + ']l_name',
            "container": '.field-deliveryaddressform-' + index + '-l_name',
            "input": '#deliveryaddressform-' + index + '-l_name',
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {"message": "Необходимо заполнить «Фамилия»."});
                yii.validation.string(value, messages, {"message": "Значение «Фамилия» должно быть строкой.", "skipOnEmpty": 1});
            }
        }, {
            "id": 'deliveryaddressform-' + index + '-city',
            "name": '[' + index + ']city',
            "container": '.field-deliveryaddressform-' + index + '-city',
            "input": '#deliveryaddressform-' + index + '-city',
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {"message": "Необходимо заполнить «Город»."});
                yii.validation.string(value, messages, {"message": "Значение «Город» должно быть строкой.", "skipOnEmpty": 1});
            }
        }, {
            "id": 'deliveryaddressform-' + index + '-address',
            "name": '[' + index + ']address',
            "container": '.field-deliveryaddressform-' + index + '-address',
            "input": '#deliveryaddressform-' + index + '-address',
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {"message": "Необходимо заполнить «Адрес»."});
                yii.validation.string(value, messages, {"message": "Значение «Адрес» должно быть строкой.", "skipOnEmpty": 1});
            }
        }, {
            "id": 'deliveryaddressform-' + index + '-phone',
            "name": '[' + index + ']phone',
            "container": '.field-deliveryaddressform-' + index + '-phone',
            "input": '#deliveryaddressform-' + index + '-phone',
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {"message": "Необходимо заполнить «Телефон»."});
                yii.validation.string(value, messages, {"message": "Значение «Телефон» должно быть строкой.", "skipOnEmpty": 1});
            }
        }], []);

    $('.del-delivery').on('click', deleteDelivery);

})
$('.del-delivery').on('click', deleteDelivery);
function deleteDelivery() {
    $(this).parent().remove();
}
