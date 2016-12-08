// Требуется реализация
function addCharacteristic(url) {
    $.ajax({
        data: '',
        method: 'POST',
        url: url,
        success: function ($data) {
            debugger;
            $('div.product-characteristic').append($data)();
            return false;
        }
    })
    // var text = $('div.add-characteristic').val();
    // var html = '<div class="col-md-1 panel  panel-success" >text</div>';
    // $('div.product-characteristic').html(html);
    // $('select#categorymodel-parent').change(function(){
    //   $('div.product-characteristic').text($('#categorymodel-parent').val());
    // })
}

$('div.panel-body button').click(addCharacteristic('dfssf/sdfds/dsf'));





