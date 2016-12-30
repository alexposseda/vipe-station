function deleteCharacter(){
    var self = $(this);
    var url = self.data('url');
    var index = self.data('index');
    if(url === undefined){
        $('#character-'+index).remove();
    }else{
        if($('#character-list .character-line').length > 1){
            $.post(url, {}, function(res){
                if(res == 1){
                    $('#character-'+index).remove();
                }else{
                    alert('Error! Cannot delete characteristic!');
                }
            });

        }else{
            $('#character-'+index).remove();
        }
    }
}

$('#add-character').on('click', function(){
    var index = $('#character-list .character-line').length;
    $('#new-character-list').append('<div class="character-line" id="character-'+index+'"><div class="form-group field-productcharacteristicmodel-'+index+'-title required"><label class="control-label" for="productcharacteristicmodel-'+index+'-title">Новая характеристика</label><div class="row no-margin"><div class="col-lg-10 col-md-10 col-sm-9 "><input type="text" id="productcharacteristicmodel-'+index+'-title" class="form-control" name="ProductCharacteristicModel['+index+'][title]" placeholder="Название"></div><div class="col-sm-3 col-md-2 col-lg-2"><button type="button" class="btn btn-sm btn-danger del-character" data-index="'+index+'"><span class="glyphicon glyphicon-remove"></span></button></div></div><div class="help-block"></div></div><input type="hidden" id="productcharacteristicmodel-'+index+'-id" name="ProductCharacteristicModel['+index+'][id]"></div>');
    $('.del-character').on('click', deleteCharacter);
});

$('#categorymodel-parent').on('change', function(){
    var category_id = $(this).val();
    if($(this).parent().data('current') != category_id) {
        var url = $(this).parent().data(url);
        $.post(url, {category_id: category_id}, function (result) {
            var categories = JSON.parse(result);
            var index = $('#character-list .character-line').length;
            var content = '';
            if (categories.length > 0) {
                content += '<p class="control-label" style="font-weight: bold;">Унаследованные характеристики</p>';
            }
            for (var i = 0; i < categories.length; i++) {
                content += '<div class="character-line" id="character-' + index + '"><div class="form-group field-productcharacteristicmodel-' + index + '-title required"><input type="text" id="productcharacteristicmodel-' + index + '-title" class="form-control" name="ProductCharacteristicModel[' + index + '][title]" placeholder="Название" value="' + categories[i].title + '" readonly><div class="help-block"></div></div><input type="hidden" id="productcharacteristicmodel-' + index + '-id" name="ProductCharacteristicModel[' + index + '][id]" value="' + categories[i].id + '"></div>';
                index++;
            }
            $('#parent-character-list').html(content);
            $('.del-character').on('click', deleteCharacter);

        });
    }
});
$('.del-character').on('click', deleteCharacter);


