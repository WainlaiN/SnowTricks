$(document).ready(function () {
    $(".moreBox").slice(0, 4).show();
    if ($(".moreBox:hidden").length != 0) {
        $("#loadMore").show();
    }
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $("#buttonUp").show();
        $(".moreBox:hidden").slice(0, 4).slideDown();
        if ($(".moreBox:hidden").length == 0) {
            $("#loadMore").fadeOut('slow');
        }
    });
    $("#buttonUp").on('click', function (e) {
        $("#buttonUp").hide();
        $(".moreBox").slice(4, 8).hide();
    });
});
