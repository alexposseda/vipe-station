function addSocial(){
    var index = $('#social-list').find('.row').length;
    var content = '<div class="row" id="soc-line-'+index+'"><div class="col-lg-1 text-center"></div><div class="col-lg-4 field-socialitemform-'+index+'-title required"><input type="text" id="socialitemform-'+index+'-title" class="form-control" name="SocialItemForm['+index+'][title]" placeholder="Title"><div class="help-block"></div></div><div class="col-lg-5 field-socialitemform-'+index+'-link required"><input type="url" id="socialitemform-'+index+'-link" class="form-control" name="SocialItemForm['+index+'][link]" placeholder="Link"><div class="help-block"></div></div><div class="col-lg-2 field-socialitemform-'+index+'-iconfile"><label class="btn btn-success" style="width: 100%" for="socialitemform-'+index+'-iconfile"><span class="glyphicon glyphicon-plus"></span></label><input type="hidden" name="SocialItemForm['+index+'][iconFile]" value=""><input type="file" id="socialitemform-'+index+'-iconfile" class="hidden" name="SocialItemForm['+index+'][iconFile]"><div class="help-block"></div></div></div>';
    $('#social-list').append(content);
}
$(document).ready(function(){
    $('.btn-warning').on('click', function(){
        var e = e || event;
        var editBtn = $(this);
        var box = editBtn.parents('.panel');
        var submitBtn = box.find('.btn[type=submit]');

        var inputs = box.find('.form-control, input').not('.btn');

        editBtn.hide();
        $('#add-soc-but').removeClass('hide');
        submitBtn.removeClass('hide');
        box.find('.setting-form').removeClass('hide');
        inputs.removeAttr('disabled');
        submitBtn.removeAttr('disabled');
    });
    $('#add-soc-but').on('click', addSocial);
    $('.del-soc-but').on('click', function(){
       var self = $(this);
       $.post(self.data('url'), {}, function(){
            $('#soc-line-'+self.data('index')).remove();
       })
    });
});
