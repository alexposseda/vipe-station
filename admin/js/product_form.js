$('#productform-categories').on('change', function () {
    var categories = $(this).val();
    var index = 0;
    var content = '';
    $.post($(this).data('getcharacter-url'), {categories: categories}, function (result) {
        for (var i = 0; i < result.length; i++) {
            content += '<div class="form-group field-productcharacteristicitemmodel-' + index + '-value required col-sm-12 col-md-6 col-lg-4"><label class="control-label" for="productcharacteristicitemmodel-' + index + '-value">' + result[i].title + '</label><input type="text" id="productcharacteristicitemmodel-' + index + '-value" class="form-control" name="ProductCharacteristicItemModel[' + result[i].characteristic_id + '][value]"><div class="help-block"></div></div>';
            index++;
        }

        $('#characteristic-list').html(content);
    });

    $.post($(this).data('getrelated-url'), {categories: categories}, function (result) {
        if (result.length > 0) {


            var content = '<div class="form-group related-products-value required"><select name="ProductForm[related_products][]" class="form-control" multiple="multiple" size="4">';
            for (var i = 0; i < result.length; i++) {
                content += '<option value="' + result[i].id + '">' + result[i].title + '</option>';
            }
            content += '</select></div>';
            $('#related').html(content);
            $('#related-alert').hide();
        } else {
            $('#related').html('');
            $('#related-alert').text('Не найдено ни одного товара').show();
        }
    });

});

$('form #cartform-quantity').on('click', function () {
    console.log('Hello');
    var input = $(this);
    var count = parseInt(input.val());
    var base_quantity = parseInt(input.data('base_quantity'));

    if (count < 1) {
        count = 1;
        alert('Invalid: value = 0');
    } else if (count > base_quantity) {
        count = base_quantity;
        alert('Invalid: value > base_quantity');
    }


    input.val(count);
})
