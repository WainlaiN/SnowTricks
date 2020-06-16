window.onload = () => {

    //gestion des boutons supprimer
    let links = document.querySelectorAll("[data-delete]")
    console.log(links)

    //on boucle sur links
    for (link of links) {
        //on écoute le clic
        link.addEventListener("click", function (e) {
            //on empeche le click
            e.preventDefault()

            //on demande confirmation
            if (confirm("Voulez-vous supprimer cette image ?")) {
                // on envoie une requete Ajax vers le href du lien avec la methode DELETE
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    }
                }).then(
                    //on recupere la reponse en JSON
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
