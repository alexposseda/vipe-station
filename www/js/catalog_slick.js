$('.catalog-wrap-content').slick({
    dots: false,
    infinite: true,
    speed: 1000,
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    arrows: true,
    prevArrow: '<div class="slick-btn-wrap prev"><span class="slick-btn"></span></div>',
    nextArrow: '<div class="slick-btn-wrap next"><span class="slick-btn"></span></div>',
    responsive: [
        {
            breakpoint: 1300,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: false
            }
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1

            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
});
