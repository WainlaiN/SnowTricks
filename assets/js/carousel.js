$(document).ready(function () {
    var currentImg = $('.active');

    if ($(window).width() > 992) {

        $('.next').on('click', function () {

            var nextImg = currentImg.next();
            if (nextImg.length) {
                currentImg.removeClass('active').css('z-index', -10);
                nextImg.addClass('active').css('z-index', 10);
            }
        });
        $('.prev').on('click', function () {

            var prevImg = currentImg.prev();
            if (prevImg.length) {
                currentImg.removeClass('active').css('z-index', -10);
                prevImg.addClass('active').css('z-index', 10);
            }
        });
    }
});


