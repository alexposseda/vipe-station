(function ($) {
    $('div.panel-body button').click(function(){
        var text = $('div.add-characteristic').val();
        var html = '<div class="col-md-1 panel  panel-success" >text</div>';
        $('div.product-characteristic').html(html);
    })
    // $('select#categorymodel-parent').change(function(){
    //   $('div.product-characteristic').text($('#categorymodel-parent').val());
    // })
})(jQuery);



