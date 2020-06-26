$(document).ready(function () {
    $(".moreComment").slice(0, 4).show();
    if ($(".moreComment:hidden").length != 0) {
        $("#loadMore").show();
    }
    $("#loadMore").on('click', function (e) {
        //e.preventDefault();
        $("#showLess").show();
        $(".moreComment:hidden").slice(0, 4).slideDown();
        if ($(".moreComment:hidden").length == 0) {
            $("#loadMore").fadeOut('slow');
        }
    });
    $("#showLess").on('click', function (e) {
        $("#showLess").hide();
        $(".moreComment").slice(4, 8).hide();

    });
});