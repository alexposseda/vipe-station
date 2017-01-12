$('.quantity-btn').on('click', function () {
    var inp = $(this).siblings('input');
    var inpValue = parseInt(inp.val());
    var action = $(this).data('action');
    var offset = 0;
    switch (action) {
        case'minus':
            offset = -1;
            break;
        case'plus':
            offset = 1;
            break;
    }
    var product = $(this).parents('.product-total');
    inp.val(inpValue + offset);

    $.post($(this).parent().data('url'), {quantity: inpValue + offset}, function (result) {
        var price = product.find('.cart-item-price');
        price.text(parseInt(price.data('price')) * parseInt(result));
        initTotalPrice();
    });
});

initTotalPrice();

function initTotalPrice() {
    var cartItems = $('.cart-item-price');
    var total = 0;
    for(var i =0 ; i < cartItems.length; i++){
        total+= parseInt($(cartItems[i]).text());
    }

    $('#total-cart-price').text(total);
}

$('#move_to_checkout').on('click', function () {
    var form = $('#order-form');
    form.submit();
});