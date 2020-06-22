$(window).resize(function () {

    if ($(window).width() < 1000) {
        $('#btn-media').show();
        $('#carousel').hide();
    } else {
        $('#btn-media').hide();
        $('#carousel').show();

    }

    $('#btn-media').on('click', function () {
        $('#carousel').show();
        $('#btn-media').hide();
    });
});