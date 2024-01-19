console.log("modale.js est lancé");

document.addEventListener("DOMContentLoaded", function () {
    // Sélectionnez les éléments nécessaires
    var openModalButton = document.querySelector(".menu-item-64");
    var modalOverlay = document.querySelector(".popup-overlay");

    // Ajoutez un gestionnaire d'événement pour le clic sur le bouton
    openModalButton.addEventListener("click", function (event) {
        // Empêcher le comportement par défaut (la redirection vers une autre page)
        event.preventDefault();

        // Ajoutez la classe "open" à la modal overlay
        modalOverlay.classList.add("open");
    });

    // Ajoutez un gestionnaire d'événement pour le clic en dehors de la modal pour la fermer
    modalOverlay.addEventListener("click", function (event) {
        if (event.target === modalOverlay) {
            // Retirez la classe "open" pour masquer la modal
            modalOverlay.classList.remove("open");
        }
    });
});

