$(document).ready(function () {
    var links = $(".data-delete");
    console.log("0");
    links.click(function (event) {

        event.preventDefault();
        confirm("voulez-vous vraiment supprimer ?");
        var a_href = $(this).attr('href');
        console.log("1");

        // AJAX Request
        $.ajax({
            context: this,
            url: a_href,
            type: 'DELETE',
            data: {path: a_href},
            success: function (data) {
                console.log("2");
                if (data.success === 1) {

                    // Remove image from HTML
                    $(this).remove();

                } else {
                    alert('Invalid ID.');
                }
            }
        });
    });
});


