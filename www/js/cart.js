$('.quantity-btn').on('click', function(){
    var inp = $(this).siblings('input');
    var inpValue = parseInt(inp.val());
    var action = $(this).data('action');
    var offset = 0;
    switch(action){
        case'minus':
            offset = -1;
            break;
        case'plus':
            offset = 1;
            break;
    }

    inp.val(inpValue+offset);

    $.post($(this).parent().data('url'), {quantity: inpValue+offset}, function(result){
        console.log(result)
    });
});
