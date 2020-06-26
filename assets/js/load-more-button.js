$(document).ready(function () {

    $(".moreBox").slice(0, 4).show();
    var length = $(".moreBox:visible").length;
    console.log(length)
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
        length = length + 4;
        console.log(length)

    });
    $("#showLess").on('click', function (e) {
        if ($(".moreBox:visible").length == 4){
            $("#showLess").hide();
        } else {
        $(".moreBox").slice(length - 4, length).hide();
        length = length -4 ;
        }
        console.log(length)

    });
});
