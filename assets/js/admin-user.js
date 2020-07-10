$(document).ready(function () {
    var switches = $(":checkbox");

    switches.click(function (event) {

        event.preventDefault();
        //confirm("voulez-vous supprimer cette image");
        var id = $(this).attr('data-id')
        var url = 'switch/' + id;
        console.log(url)

        // AJAX Request
        $.ajax({
            context: this,
            url: url,
            type: 'POST',

            success: function (response) {
                console.log(response);
                if (response.success === 1) {

                    // Remove image from HTML
                    if ($(this).is(":checked")) {
                        $(this).prop("checked", false);
                    } else {
                        $(this).prop("checked", true);
                    }

                } else {
                    alert('Problème technique.');
                }
            }
        });

    });

});