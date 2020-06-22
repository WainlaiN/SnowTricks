$(window).resize(function() {
    if( $(window).width() < 1000) {
        $('#btn-media').show();
        $('#carousel').hide();
    } else {
        $('#btn-media').hide();
        $('#carousel').show();

    }

    $('.prev').on('click', function () {
        var currentImg = $('.active');
        var prevImg = currentImg.prev();

        if (prevImg.length) {
            currentImg.removeClass('active').css('z-index', -10);
            prevImg.addClass('active').css('z-index', 10);
        }
    });

});