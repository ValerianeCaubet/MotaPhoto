///////////////////////////////////// LOAD MORE BUTTON //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

jQuery(document).ready(function($) {
    var page = 1;
    var loading = false;

    $('#load-more-btn').on('click', function() {
        if (!loading) {
            loading = true;
            page++;

            // Débogage - Vérifier les données envoyées
            console.log('Données envoyées : ' + JSON.stringify(load_more_params));

            var data = {
                action: 'load_more_posts',
                paged: page,
                posts_per_page: load_more_params.posts_per_page
            };

            // Débogage - Vérifier les données à envoyer
            console.log('Données à envoyer : ' + JSON.stringify(data));

            jQuery.ajax({
                url: load_more_params.ajaxurl,
                data: data,
                type: 'POST',
                success: function(response) {
                    if (response) {
                        jQuery('#post-container').append(response);
                        loading = false;
                    } else {
                        jQuery('#load-more-message').text('Aucun autre contenu à charger.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Débogage - Vérifier les erreurs AJAX
                    console.error('Erreur AJAX : ' + textStatus, errorThrown);
                }
            });
        }
    });
});

////////////////////////////////////////// LIST SELECTS ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

// Ajoute un écouteur d'événements au document pour fermer les listes déroulantes
jQuery(document).on("click", function(event) {
    closeDropdownIfOutside(event, "#select-categories");
    closeDropdownIfOutside(event, "#select-formats");
    closeDropdownIfOutside(event, "#select-by-date");
});


// Écouteur d'événements pour les listes déroulantes
jQuery("#select-categories, #select-formats, #select-by-date").on("click", ".dropdown-item", function() {
    // Récupére les valeurs sélectionnées
    const selectedCategory = jQuery("#select-categories .selected-option").data("value");
    const selectedFormat = jQuery("#select-formats .selected-option").data("value");
    const sortType = jQuery("#select-by-date .selected-option").data("value");

    // Effectue une requête AJAX pour récupérer les résultats filtrés
    filterPosts(selectedCategory, selectedFormat, sortType);
});


// Écouteurs d'événements pour les boutons des listes déroulantes
bindDropdownEvents("#mainDropdownButtonCategories", "#select-categories");
bindDropdownEvents("#mainDropdownButtonFormats", "#select-formats");
bindDropdownEvents("#mainDropdownButtonDate", "#select-by-date");

// Fonction pour basculer la visibilité du contenu de la liste déroulante
function toggleDropdown(dropdown) {
    dropdown.toggleClass("active");
}

// Fonction pour gérer la sélection d'une option
function selectOption(button, label, value) {
    const buttonContainer = button.closest(".custom-dropdown");
    buttonContainer.find(".dropdown-button").text(label);
    console.log("Option sélectionnée :", {
        label,
        value
    });

    const items = buttonContainer.find(".dropdown-item");
    items.removeClass("selected-option");
    button.addClass("selected-option");

    toggleDropdown(buttonContainer);
}

// Fonction pour fermer la liste déroulante si le clic est à l'extérieur
function closeDropdownIfOutside(event, dropdownSelector) {
    if (!jQuery(event.target).closest(dropdownSelector).length) {
        jQuery(dropdownSelector).removeClass("active");
    }
}

// Fonction pour lier les événements aux boutons des listes déroulantes
function bindDropdownEvents(mainButtonSelector, dropdownSelector) {
    const mainDropdownButton = jQuery(mainButtonSelector);
    mainDropdownButton.click(function() {
        toggleDropdown(jQuery(this).parent());
    });

    const dropdownItems = jQuery(`${dropdownSelector} .dropdown-item`);
    dropdownItems.click(function() {
        const label = jQuery(this).text();
        const value = jQuery(this).data("value");
        selectOption(jQuery(this), label, value);
    });
}

// Définition de la fonction pour réinitialiser le chargement de plus de contenu
function resetLoadMore() {
    // Ajoutez ici le code pour réinitialiser le chargement de plus de contenu, par exemple :
    page = 1; // Réinitialise la page à 1
    loading = false; // Réinitialise le drapeau de chargement
}

// Ajoutez-la avant l'appel à resetLoadMore() dans votre fonction filterPosts
function filterPosts(selectedCategory, selectedFormat, sortType) {
    jQuery.ajax({
        url: ajax_object.ajax_url,
        type: "POST",
        data: {
            action: "filter_posts",
            category: selectedCategory,
            format: selectedFormat,
            sortType: sortType,
        },
        success: function(response) {
            // Mise à jour du contenu de la div avec les résultats filtrés
            jQuery("#post-container").html(response);
            resetLoadMore(); // Appel à la fonction resetLoadMore
        },
        error: function(error) {
            console.error("Erreur AJAX :", error);
        },
    });
}
