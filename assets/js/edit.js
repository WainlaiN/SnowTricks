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

/**window.onload = () => {

    //manage delete button
    let links = document.querySelectorAll("[data-delete]")
    console.log(links)

    //loop on links(data-delete) buttons
    for (link of links) {
        //listening to the click
        link.addEventListener("click", function (e) {
            //prevent the click
            e.preventDefault()

            //ask for confirmation
            if (confirm("Voulez-vous supprimer cette image ?")) {
                //send AJAX request to the href with DELETE method
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    }
                }).then(
                    //get the JSON response
                    response => response.json()
                ).then(data => {
                    if (data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        })
    }
}**/
