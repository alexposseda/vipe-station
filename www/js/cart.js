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
        initTotalPrice();
    });
});

initTotalPrice();

function initTotalPrice() {
    var cartItems = $('.cart-item-price');
    var total = 0;
    for(var i =0 ; i < cartItems.length; i++){
        debugger;
        total+= parseInt($(cartItems[i]).text());
    }
    console.log(total);
    console.log(cartItems);

    $('#total-cart-price').text(total);
}

$('#move_to_checkout').on('click', function () {
    var form = $('#order-form');
    form.submit();
});