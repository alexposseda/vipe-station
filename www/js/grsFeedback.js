(function($){
    var panel;
    var tabs;
    var pluginActions = {
        showPanel    : function(){
            if(!panel.hasClass('active')){
                panel.animate({
                    right : '390px',
                    height: $('#' + $(this).data('target')).outerHeight() + 20
                }, 500, function(){
                    panel.addClass('active');
                    $('.' + panel.attr('id') + '-btn-close').show();
                });
            }
        },
        closePanel   : function(){
            $(this).hide();
            $('.' + panel.attr('id') + '-btn').removeClass('active');
            panel.animate({
                right : '66px',
                height: $('.' + panel.attr('id') + '-tab-panel').outerHeight() + 20
            }, 500, function(){
                panel.removeClass('active');
                tabs.fadeOut().removeClass('active');
                pluginActions.hidePreloader();
            });
        },
        switchTab    : function(id){
            var target = $('#' + id);
            $('.' + panel.attr('id') + '-btn').not($(this)).removeClass('active');
            $(this).addClass('active');
            tabs.not(target).fadeOut().removeClass('active');
            panel.animate({
                height: target.outerHeight() + 20
            }, 500);
            target.fadeIn(500).addClass('active');
        },
        sendForm     : function(formId, event){
            event.preventDefault();
            pluginActions.showPreloader();

            //todo ajax must be here
        },
        showPreloader: function(){
            panel.find('.preloader').show();
        },
        hidePreloader: function(){
            panel.find('.preloader').hide();
        },
        showMessage  : function(message){
            Materialize.toast(message, 3000)
        }
    };

    $.fn.grsFeedback = function(){
        panel = this;
        tabs  = panel.find('.' + panel.attr('id') + '-tab').hide();
        panel.css('right', 66);

        panel.find('.btn').on('click', function(event){
            var actions = $(this).data('action').split(' ');
            for(var i = 0; i < actions.length; i++){
                if(actions[i] in pluginActions){
                    pluginActions[actions[i]].apply(this, [$(this).data('target'), event]);
                }
            }
        });
    }
})(jQuery);