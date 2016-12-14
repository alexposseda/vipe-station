(function($){
    /**
     *
     * @param {jQuery}  el
     * @param {number} offset
     */
    function setHeight(el, offset){
        if(offset === undefined){
            offset = 0;
        }
        if(el.outerHeight() < $(window).height() + offset){
            el.height($(window).height() + offset);
        }
    }

    /**
     *
     * @param offset integer
     * @returns {jQuery}
     */
    $.fn.fullHeight = function(offset){
        this.each(function(){
            setHeight($(this), offset);
        });
        var self = this;
        $(window).on('resize', function(){
            self.each(function(){
                setHeight($(this), offset);
            });
        });
        return this;
    }
})(jQuery);