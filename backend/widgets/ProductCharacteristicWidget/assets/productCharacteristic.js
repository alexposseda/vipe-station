(function ($) {
    $('select#categorymodel-parent').change(function(){
      $('div.product-characteristic').text($('#categorymodel-parent').val());
    })
})(jQuery);
