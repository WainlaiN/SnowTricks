$(document).ready(function () {

    $(".moreComment").slice(0, 4).show();

    var commentLength = $(".moreComment:hidden").length;

    if (commentLength === 0) {
        $("#loadMoreComment").hide();
    } else {
        $("#loadMoreComment").show();
    }
    $("#loadMoreComment").on('click', function (e) {

        $(".moreComment:hidden").slice(0, 4).slideDown();
        commentLength = commentLength - 4;
        if (commentLength <= 0) {
            $("#loadMoreComment").hide();
        }
    });
});