$('.quantity-btn').on('click', function () {
    var inp = $(this).siblings('input');
    var inpValue = parseInt(inp.val());
    var action = $(this).data('action');
    var offset = 0;
    switch (action) {
        case'minus':
            if (inpValue == 1) {

                break;
            }
            offset = -1;
            break;
        case'plus':
            //console.log(parseInt(inp.data('base_quantity')));
            if (parseInt(inp.data('base_quantity')) == inpValue) {
                break;
            }
            offset = 1;
            break;
    }
    var product = $(this).parents('.product-total');

    $.post($(this).parent().data('url'), {quantity: inpValue + offset}, function (result) {
        if (result) {
            inp.val(inpValue + offset);
            var price = product.find('.cart-item-price');
            price.text(parseInt(price.data('price')) * parseInt(result));
            initTotalPrice();
        }
    });
});

initTotalPrice();

function initTotalPrice() {
    var cartItems = $('.cart-item-price');
    var total = 0;
    for (var i = 0; i < cartItems.length; i++) {
        total += parseInt($(cartItems[i]).text());
    }

    $('#total-cart-price').text(total);
}

$('#move_to_checkout').on('click', function () {
    var form = $('#order-form');
    form.submit();
});