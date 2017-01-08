$('#productsearchmodel-brand_id').on('change',function () {
    $('#catalog-search').submit();
});
$("#range-filter").ionRangeSlider({
    type: "double",
    min: $(this).data('min'),
    max: $(this).data('max'),
    postfix: "uah",
    onFinish: function(){
        $('#catalog-search').submit()
    }
});