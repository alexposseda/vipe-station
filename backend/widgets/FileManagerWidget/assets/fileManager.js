(function ($) {

    $.fn.fileUpload = function (uploadUrl) {
        return this.on('change', function(){
            var self = $(this);
            self.trigger('uploadFile:start');
            var file = this.files[0];
            var form = new FormData();
            form.append(self.attr('name'), file);

            $.ajax({
                url: uploadUrl,
                type: 'POST',
                contentType: false,
                processData: false,
                data: form,
                success: function (response) {
                    self.trigger('uploadFile:end', [response]);
                }
            });
        });
    }
})(jQuery);

(function ($) {
    $.fn.removeFile = function (removeUrl, attr) {
        return this.on('click', function () {
            console.log(this);
            $(this).trigger('removeFile:start');
            var attribute = attr;
            var path = $(this).data('path');
            var self = $(this);
            $.ajax({
                url: removeUrl,
                type: 'POST',
                data: attribute + '=' + path,
                success: function (response) {
                    console.log(response);
                    self.trigger('removeFile:end', [response]);
                }
            });
        });
    }
})(jQuery);