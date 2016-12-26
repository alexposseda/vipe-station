$(document).ready(function(){
    $('.btn-warning').on('click', function(){
        var e = e || event;
        var editBtn = $(this);
        var box = editBtn.parents('.panel');
        var submitBtn = box.find('.btn[type=submit]');

        var inputs = box.find('.form-control, input').not('.btn');

        editBtn.hide();
        submitBtn.removeClass('hide');
        box.find('.setting-form').removeClass('hide');
        inputs.removeAttr('disabled');

        inputs.on('change', function(){
            submitBtn.removeAttr('disabled');
        });
    });

    $('.del-soc-but').on('click', function(){
        console.log('sads');
       var self = $(this);
       $.post(self.data('url'), {}, function(){
            $('#soc-line-'+self.data('index')).remove();
       })
    });
});
