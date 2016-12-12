$('#stockmodel-policy_id').change(function () {
    if ($(this).val()) {
        $.ajax({
            'url': 'http://admin.vipe.local/stock/render-ajax',
            'data': {'police_id': $(this).val()},
            'success': function (response) {
                $('#stock-value-wrapper').html(response);
            }
        });
    }
});

function initStockVal(police, stock_value) {
    console.log(police);
    console.log(stock_value);
    if (police && stock_value) {
        console.log('dfg');
        $.ajax({
            'url': 'http://admin.vipe.local/stock/render-ajax',
            'data': {'police_id': police, 'stock_value': stock_value},
            'success': function (response) {
                $('#stock-value-wrapper').html(response);
            }
        });
    }
}

$('#stock-form').submit(function () {
    var gift = $('#products-gift').val();
    if (gift) {
        var json = JSON.encode({'gift': gift});
        $('#stockmodel-stock_value').val(json);
    }
});