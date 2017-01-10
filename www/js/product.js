
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

    $('.option-select select').on('change', function(){
        // $(this).attr('name', 'product_id');
        $('.product-gallery-wrap').slick('destroy');
        $('#selectOptionForm').submit();
    });
    $("#productPjaxContainer").on("pjax:end", function() {
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
