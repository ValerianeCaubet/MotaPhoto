document.addEventListener("DOMContentLoaded", function () {
    // Sélectionnez les éléments nécessaires
    var openModalButtonMenu = document.querySelector(".menu-item-64");
    var openModalButtonSingle = document.getElementById("boutonContact");
    var modalOverlay = document.querySelector(".popup-overlay");

    // Fonction pour ouvrir la modale
    function openModal() {
        // Ajoutez la classe "open" à la modal overlay
        modalOverlay.classList.add("open");
    }

    // Ajoutez un gestionnaire d'événement pour le clic sur le bouton du menu
    openModalButtonMenu.addEventListener("click", function (event) {
        // Empêcher le comportement par défaut (la redirection vers une autre page)
        event.preventDefault();
        openModal();
    });

    // Ajoutez un gestionnaire d'événement pour le clic sur le bouton dans le fichier single
    openModalButtonSingle.addEventListener("click", function (event) {
        // Empêcher le comportement par défaut (la redirection vers une autre page)
        event.preventDefault();
        openModal();
    });

    // Ajoutez un gestionnaire d'événement pour le clic en dehors de la modal pour la fermer
    modalOverlay.addEventListener("click", function (event) {
        if (event.target === modalOverlay) {
            // Retirez la classe "open" pour masquer la modal
            modalOverlay.classList.remove("open");
        }
    });
});

