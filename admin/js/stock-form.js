$('#stockmodel-policy_id').change(function () {
    var policy = $(this);
    if ($(this).val()) {
        $.ajax({
            'url': 'http://admin.vipe.local/stock/render-ajax',
            'data': {'police_id': policy.val()},
            'success': function (response) {
                $('#stock-value-wrapper').html(response);
            }
        });
    }
});

function initStockVal(police, stock_value) {
    if (police && stock_value) {
        $.ajax({
            'url': 'http://admin.vipe.local/stock/render-ajax',
            'data': {'police_id': police, 'stock_value': stock_value},
            'success': function (response) {
                $('#stock-value-wrapper').html(response);
            }
        });
    }
}

$('#stock-sub').click(function () {
    var gift = $('#products-gift').val();
    if (gift) {
        var json = JSON.stringify({'gift':gift});
        console.log(json);
        $('#stockmodel-stock_value').val(json);
    }
});