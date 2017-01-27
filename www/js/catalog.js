
$('#productsearchmodel-brand_id').on('change',function () {
    $('#catalog-search').submit();
});

$('#productsearchmodel-category_id').on('change',function () {
    $('#catalog-search').submit();
});
function rangeInit() {
    try {
        $("#range-filter").ionRangeSlider({
            type: "double",
            min: $(this).data('min'),
            max: $(this).data('max'),
            from: rangeFrom,
            to: rangeTo,
            postfix: "грн",
            onFinish: function () {
                $('#catalog-search').submit()
            }
        });
    } catch (e) {
        $("#range-filter").ionRangeSlider({
            type: "double",
            min: $(this).data('min'),
            max: $(this).data('max'),
            postfix: "грн",
            onFinish: function () {
                $('#catalog-search').submit()
            }
        });
    }
}