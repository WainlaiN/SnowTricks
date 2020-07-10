$(document).ready(function () {
    var links = $(".data-delete");

    links.click(function (event) {

        event.preventDefault();
        confirm("voulez-vous supprimer cette image");
        var a_href = $(this).attr('href');

        // AJAX Request
        $.ajax({
            context: this,
            url: a_href,
            type: 'DELETE',
            data: {path: a_href},
            success: function (response) {
                console.log(response);
                if (response.success === 1) {

                    // Remove image from HTML
                    $(this).remove();

                } else {
                    alert('Invalid ID.');
                }
            }
        });
    });
});


