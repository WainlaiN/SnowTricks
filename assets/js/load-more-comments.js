$(document).ready(function () {
    var commentLength = $(".moreComment:hidden").length;
    $(".moreComment").slice(0, 4).show();
    if (commentLength != 0) {
        $("#loadMoreComment").show();
    }
    $("#loadMoreComment").on('click', function (e) {
        //e.preventDefault();

        $(".moreComment:hidden").slice(0, 4).slideDown();
        if (commentLength == 0) {
            $("#loadMoreComment").fadeOut('slow');
        }
    });

});