function initParallax() {
    $('.parallax').each(function () {
        var content = $(this).parent().find('.parallax-content');

        if (content.outerHeight() > 500) {
            $(this).parent().height(content.outerHeight() + 100);
            $(this).parallax();
        } else {
            $(this).parallax();
        }
    });

}

function initBanner() {
    $(".banner").slider({
        height: $(".section-banner").height(),
        transition: 1000
    });
}

function initProjectSlider() {
    $("#portfolio-preview-slider").slider({
        height: $('.portfolio-preview-slider-wrap').height() - 40,
    }).find(".portfolio-preview-slider-btn").on('click', function () {
        $("#portfolio-preview-slider").slider($(this).data('action'));
    });
}
var langListW = 50;
function showHideLangList() {
    if ($('#navbar-menu').outerWidth() > $('.nav-wrapper').outerWidth() - $('#brand-logo').width()) {
        $('#navbar-menu .lang-list-wrap').addClass('no-margin-left');
        $('#lang-but').addClass('visible');
        $('#lang-list').addClass('dropdown-content');
    } else if ($('#navbar-menu').outerWidth() + langListW < $('.nav-wrapper').outerWidth() - $('#brand-logo').width()) {
        $('#navbar-menu .lang-list-wrap').removeClass('no-margin-left');
        $('#lang-but').removeClass('visible');
        $('#lang-list').removeClass('dropdown-content');
    }
}

function popupToModal(toModal) {
    if (toModal) {
        $('.modal').each(function () {
            if ($(this).hasClass('popup-bottom')) {
                $(this).addClass('bottom-sheet');
            }
            if ($(this).hasClass('popup-fixed-footer')) {
                $(this).addClass('modal-fixed-footer');
            }

            $(this).removeClass('popup-active');
        });
    } else {
        $('.popup').each(function () {
            if ($(this).hasClass('popup-bottom')) {
                $(this).removeClass('bottom-sheet');
            }
            if ($(this).hasClass('popup-fixed-footer')) {
                $(this).removeClass('modal-fixed-footer');
            }

            $(this).addClass('popup-active');
        });
    }
}

function updateSpinner(obj) {
    debugger;
    var contentObj = document.getElementById("count");
    var value = parseInt(contentObj.value);
    if (obj.id == "down") {
        if (value != 0)
            value--;
    } else {
        value++;
    }
    contentObj.value = value;
}

$('div.count-yoy-order a').on('click', function () {
    var input = $(this).siblings('input');
    var count = parseInt(input.val());
    var base_quantity = parseInt(input.data('base_quantity'));

    var price = parseFloat($(this).parents('.product-total').find('.all_price').data('base_price'));
    if ($(this).hasClass('down')) {
        if (count != 1)
            count--;
    } else {
        if(count < base_quantity)
        count++;
    }
    price = price * count;
    $(this).parents('.product-total').find('.all_price').text(price);
    input.val(count);
    TotalCount();
})

function TotalCount() {
    var total_price = 0;
    $('.product-total').each(function(){
        total_price += parseFloat($(this).find('span.all_price').text());
    });
    $('span#total-price').text(total_price);
}


$(document).ready(function () {
    $('.button-collapse').sideNav({
        menuWidth: 320, // Default is 240
        edge: 'left', // Choose the horizontal origin
        draggable: true
    });

    $('.side-nav, .section-one').fullHeight();


    $('#lang-but').dropdown();
    $('#lang-list li').each(function () {
        langListW += $(this).width();
    });

    showHideLangList();

    $(window).on('load resize', function () {
        if ($(this).width() > 992) {
            popupToModal(false);
            showHideLangList();
        }
        else {
            popupToModal(true);
        }
    });

    $(document).ready(function () {
        $('select').material_select();
    });

    $('.modal-trigger').leanModal({
        starting_top: 0,
    });

    $('.side-nav-modal').click(function (e) {
        var href = $(this).attr('href');
        // $(href).leanModal('open');

    });

    //range
    $("#range-filter").ionRangeSlider({
        type: "double",
        min: $(this).data('min'),
        max: $(this).data('max'),
        postfix: "uah"
    });

    $('#form_filter').find('#brand_select').on('change', function () {
        form = this.form;
        $(form).submit();
    });

    $(window).on('load resize', function () {
        $('.section-title').fullHeight(-$('header').height());
        var divs = $grid.find('.wrap-overflow');
        if (divs.parent().hasClass("items-row")) {
            $('.items-row').unwrap();
            divs.unwrap();
        }
        $grid.width('');
        $grid.isotope();
    });

    var $grid = $('.products-wrapper-isotope').isotope({
        itemSelector: '.wrap-overflow'
    });

    $grid.on('arrangeComplete', function () {
        var self = $(this),
            divs = self.find('.wrap-overflow'),
            itemWidth = self.find('.wrap-overflow').outerWidth(),
            contentWidth = self.width(),
            itemsPerRow = contentWidth / itemWidth;

        self.width(Math.floor(itemsPerRow) * itemWidth);

        if (divs.parent().hasClass("items-row")) {
            $('.items-row').unwrap();
            divs.unwrap();
        } else {
            for (var i = 0; i < divs.length; i += itemsPerRow) {
                divs.slice(i, i + itemsPerRow).wrapAll("<div class='items-row'></div>");
            }
            $('.items-row').wrap("<div class='items-row-wrapper'></div>");
        }

        var biggestHeight = 0;
        $(".items-row").each(function () {
            var items = $(this).find('.wrap-overflow');
            items.each(function () {
                if ($(this).outerHeight() > biggestHeight) {
                    biggestHeight = $(this).outerHeight();
                }
            });

        });
        $(".items-row").height(biggestHeight);
    });

    $('#close-sidenav').click(function () {
        $('.button-collapse').sideNav('hide');
    });

    $('ul.tabs').tabs();

});