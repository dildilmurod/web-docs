$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        margin: 10,
        loop: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        smartSpeed: 500,
        navText: ['<i class="fa fa-angle-double-left"></i>','<i class="fa fa-angle-double-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            800: {
                items: 2
            },
            1100: {
                items: 3
            }
        },
        dots: false
    });
    $(window).scroll(function() {
        if ($(this).scrollTop() > $(this).height()) {
            $('.top').addClass('active');
        } else {
            $('.top').removeClass('active');
        }
    });
    $('.top').click(function() {
        $('html, body').stop().animate({scrollTop: 0}, 'slow', 'swing');
    });

    asideHeight();
    rightArtHeight();







    sliderColorMain();
    sliderColorSecondary();
    sliderColorSmallest();

});
$(window).on('load', function(){
    $('.preloader').delay(1000).fadeOut('slow');
})

function asideHeight(){
    // console.log($('.s-section').height() - $('.asidebox').height() - 33);
    // console.log($('.s-section').height());
    // console.log($('.asidebox').height());
    var asideStat = $('.s-section').height() - $('.asidebox').height() - 33;
    $('.aside-stat').height(asideStat);
}
function rightArtHeight(){
    var lastArt = $('.news-main').innerHeight() - $('.banner').outerHeight() - 30;
    $('.last-art').height(lastArt);
}

// function sliderColorMain(){
//   $('.news-main').mouseenter(function(){
//       $(this).find('.sliding-color').slideDown(500);
//       $(this).find('h2').addClass('color-hover');
//       $(this).find('p').addClass('color-hover');
//       $(this).find('.content-big').removeClass('content-unhover').addClass('content-hover');
//     });

//     $('.news-main').mouseleave(function(){
//       $(this).find('.sliding-color').slideUp(500);
//       $(this).find('h2').removeClass('color-hover');
//       $(this).find('p').removeClass('color-hover');
//       $(this).find('.content-big').removeClass('content-hover').addClass('content-unhover');
//     });
// }
var timer;
function sliderColorMain(){
    $('.news-main').mouseenter(function(){
        $(this).find('.sliding-color').stop(true).slideDown(500);
        $(this).find('h2').addClass('color-hover');
        $(this).find('p').addClass('color-hover');
        // $(this).find('.content-big').removeClass('content-unhover').addClass('content-hover');
    }).mouseleave(function(){
        // clearTimeout(timer);
        $(this).find('.sliding-color').stop(true).slideUp(250);
        $(this).find('h2').removeClass('color-hover');
        $(this).find('p').removeClass('color-hover');
        // $(this).find('.content-big').removeClass('content-hover').addClass('content-unhover');
    });
}
function sliderColorSecondary(){
    $('.news-second').mouseenter(function(){
        $(this).find('.sliding-color').stop(true).slideDown(500);
        $(this).find('h2').addClass('color-hover');
        $(this).find('p').addClass('color-hover');
        // $(this).find('.content-small').removeClass('content-unhover').addClass('content-hover');
    });
    $('.news-second').mouseleave(function(){
        $(this).find('.sliding-color').stop(true).slideUp(250);
        $(this).find('h2').removeClass('color-hover');
        $(this).find('p').removeClass('color-hover');
        // $(this).find('.content-small').removeClass('content-hover').addClass('content-unhover');
    });
}
function sliderColorSmallest(){
    $('.smallest').mouseenter(function(){
        $(this).find('.sliding-color').stop(true).slideDown(500);
        $(this).find('h2').addClass('color-hover');
        $(this).find('p').addClass('color-hover');
        // $(this).find('.content-small').removeClass('content-unhover').addClass('content-hover');
    });
    $('.smallest').mouseleave(function(){
        $(this).find('.sliding-color').stop(true).slideUp(250);
        $(this).find('h2').removeClass('color-hover');
        $(this).find('p').removeClass('color-hover');
        // $(this).find('.content-small').removeClass('content-hover').addClass('content-unhover');
    });
}