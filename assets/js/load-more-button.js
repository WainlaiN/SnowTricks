$(document).ready(function () {
    $(".moreBox").slice(0, 4).show();
    if ($(".moreBox:hidden").length != 0) {
        $("#loadMore").show();
    }
    $("#loadMore").on('click', function (e) {
        //e.preventDefault();
        $("#showLess").show();
        $(".moreBox:hidden").slice(0, 4).slideDown();
        if ($(".moreBox:hidden").length == 0) {
            $("#loadMore").fadeOut('slow');
        }
    });
    $("#showLess").on('click', function (e) {
        $("#showLess").hide();
        $(".moreBox").slice(4, 8).hide();

    });
});
