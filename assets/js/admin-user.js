$(document).ready(function () {
    var switches = $(".checkbox");

    switches.click(function (event) {

        event.preventDefault();
        //confirm("voulez-vous supprimer cette image");
        var a_href = $(this).attr('href');

        // AJAX Request
        $.ajax({
            context: this,
            url: a_href,
            type: 'GET',
            data: {'data-id'},
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