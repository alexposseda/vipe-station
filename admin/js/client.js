/**
 * Created by gektorgit on 12.12.16.
 */
$('button.add-delivery').click(function () {
    var html = '<div class="address-input">' +
        '<input type="text" name="firstName" placeholder="Имя" style="width: 15%;">' +
        '<input type="text" name="lastName" placeholder="Фамилия" style="width: 15%;"> ' +
        '<input type="text" name="city" placeholder="Город" style="width: 15%;">' +
        '<input type="text" name="address" placeholder="Адрес" style="width: 38%;">' +
        '<input type="text" name="phone" placeholder="Телефон" style="width: 15%;"> ' +
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
