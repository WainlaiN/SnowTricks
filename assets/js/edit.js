window.onload = () => {

    //gestion des boutons supprimer
    let links = document.querySelectorAll("[data-delete]")
    console.log(links)

    //on boucle sur links
    for (link of links){
        //on écoute le clic
        link.addEventListener("click", function (e) {
            //on empeche le click
            e.preventDefault()

            //on demande confirmation
            if (confirm("Voulez-vous supprimer cette image ?")){

            }

        })
    }


}