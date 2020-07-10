$(document).ready(function () {
    var switches = $(":checkbox");

    switches.click(function () {

        //event.preventDefault();

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

                    alert("Changement de statut utilisateur validé");
                    // Refresh checkbox
                    //if ($(this).is(":checked")) {
                    //   $(this).prop("checked", false);
                    //} else {
                    //    $(this).prop("checked", true);
                    //}

                    //checkboxradio('refresh');


                } else {
                    alert('Problème technique.');
                }
            }
        });
    });
});