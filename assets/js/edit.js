window.onload = () => {

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
}
