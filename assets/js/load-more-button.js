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

/**
$(document).ready(function () {
    // Load the first 3 list items from another HTML file
    //$('#myList').load('externalList.html li:lt(3)');
    $(".moreBox").slice(0, 4).show();
    $('#showLess').hide();
    var items =  10;
    var shown =  4;
    $('#loadMore').click(function () {
        $('#showLess').show();
        shown = $('#moreBox:visible').length+4;
        console.log(shown)
        if(shown< items) {$('#moreBox:lt('+shown+')').show();}
        else {$('#myList li:lt('+items+')').show();
            $('#loadMore').hide();
        }
    });
    $('#showLess').click(function () {
        $('#myList li').not(':lt(3)').hide();
    });
});**/


