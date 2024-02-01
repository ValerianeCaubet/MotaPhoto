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

    // Fonction pour fermer la modale
    function closeModal() {
        // Retirez la classe "open" pour masquer la modal
        modalOverlay.classList.remove("open");
    }

    // Ajoutez un gestionnaire d'événement pour le clic sur le bouton du menu
    if (openModalButtonMenu) {
        openModalButtonMenu.addEventListener("click", function (event) {
            // Empêcher le comportement par défaut (la redirection vers une autre page)
            event.preventDefault();
            openModal();
        });
    }

    // Ajoutez un gestionnaire d'événement pour le clic sur le bouton dans le fichier single
    if (openModalButtonSingle) {
        openModalButtonSingle.addEventListener("click", function (event) {
            // Empêcher le comportement par défaut (la redirection vers une autre page)
            event.preventDefault();
            openModal();
        });

        // Ajoutez un gestionnaire d'événement pour le clic sur le bouton de la page infos
        openModalButtonSingle.addEventListener("click", function (event) {
            event.preventDefault();
            openModal();
            let refc = document.querySelector(".ref-val");
            let refmodale = document.querySelector(".refphoto");
            if (refc) {
                refmodale.value = refc.textContent;
            }
        });
    }

    // Ajoutez un gestionnaire d'événement pour le clic en dehors de la modal pour la fermer
    if (modalOverlay) {
        modalOverlay.addEventListener("click", function (event) {
            if (event.target === modalOverlay) {
                closeModal();
            }
        });
    }
});


