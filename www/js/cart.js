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

    inp.val(inpValue + offset);

    $.post($(this).parent().data('url'), {quantity: inpValue + offset}, function (result) {
        var price = $('.cart-item-price');
        price.text(parseInt(price.data('price')) * parseInt(result));
    });
});

initTotalPrice();

function initTotalPrice() {
    var totalPrice = $('#total-cart-price');
    var cartItems = $('.cart-item-price');
    console.log(totalPrice);
    console.log(cartItems);
}

$('#move_to_checkout').on('click', function () {
    var form = $('#order-form');
    form.submit();
});