function addToCart(){
    var q = $('#product-quantity').val();
    var p_id = $('#product_id').val();
    var query = 'CartForm[product_id]='+p_id+'&CartForm[quantity]='+q;
    $.post($(this).data('url'), query, function(result){
        Materialize.toast('товар успешно добавлен в корзину', 4000);
        $('#cart-count').text(result);
    })
}
$(function () {
    $('.product-gallery-wrap').slick({
        dots: true,
        infinite: true,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false
    });
    $('#addToCart').on('click', addToCart);
    $('.option-select select').on('change', function(){
        // $(this).attr('name', 'product_id');
        $('.product-gallery-wrap').slick('destroy');
        $('#selectOptionForm').submit();
    });
    $("#productPjaxContainer").on("pjax:end", function() {
        $('#addToCart').on('click', addToCart);
        $('select').material_select();
        $('.option-select select').on('change', function(){
            // $(this).attr('name', 'product_id');
            $('#selectOptionForm').submit();

        });
        $('.product-gallery-wrap').slick({
            dots: true,
            infinite: true,
            speed: 1000,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false
        });
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
        });
    });
    $('.quantity-btn').on('click', function(){
        var inp = $(this).siblings('input');
        var base_quantity = parseInt(inp.data('base_quantity'));
        console.log(base_quantity);
        var inpValue = parseInt(inp.val());
        var action = $(this).data('action');
        var offset = 0;
        switch(action){
            case'minus':
                if(inpValue != 1)
                offset = -1;
                break;
            case'plus':
                if(inpValue != base_quantity)
                offset = 1;
                break;
        }

        inp.val(inpValue+offset);
    });

});
