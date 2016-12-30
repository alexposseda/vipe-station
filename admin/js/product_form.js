$('#productform-categories').on('change', function () {
    var categories = $(this).val();
    var index = 0;
    var content = '';
    $.post($(this).data('url'), {categories: categories}, function(result){
        for(var i = 0; i < result.length; i++){
            content += '<div class="form-group field-productcharacteristicitemmodel-'+index+'-value required"><label class="control-label" for="productcharacteristicitemmodel-'+index+'-value">'+result[i].title+'</label><input type="text" id="productcharacteristicitemmodel-'+index+'-value" class="form-control" name="ProductCharacteristicItemModel['+index+'][value]"><div class="help-block"></div><input type="hidden" name="ProductCharacteristicItemModel['+index+'][characteristic_id]" value="'+result[i].characteristic_id+'"></div>';
            index++;
        }

        $('#characteristic-list').html(content);
    })

});
