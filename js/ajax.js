 
  /////////////////////////// LOAD MORE BUTTON /////////////////////
  /////////////////////////////////////////////////////////////////

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

            $.ajax({
                url: load_more_params.ajaxurl,
                data: data,
                type: 'POST',
                success: function(response) {
                    if (response) {
                        $('#post-container').append(response);
                        loading = false;
                    } else {
                        $('#load-more-message').text('Aucun autre contenu à charger.');
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

/////////////////////////////////// LIST SELECTS ///////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

// Ajoute un écouteur d'événements au document pour fermer les listes déroulantes
$(document).on("click", function (event) {
    closeDropdownIfOutside(event, "#select-categories");
    closeDropdownIfOutside(event, "#select-formats");
    closeDropdownIfOutside(event, "#select-by-date");
  });
  
  // Écouteur d'événements pour les listes déroulantes
  $("#select-categories, #select-formats, #select-by-date").on("click", ".dropdown-item", function () {
      // Récupére les valeurs sélectionnées
      const selectedCategory = $("#select-categories .selected-option").data("value");
      const selectedFormat = $("#select-formats .selected-option").data("value");
      const sortType = $("#select-by-date .selected-option").data("value");
  
      //console.log(sortType);
  
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
      console.log("Option sélectionnée :", { label, value });
  
      const items = buttonContainer.find(".dropdown-item");
      items.removeClass("selected-option");
      button.addClass("selected-option");
  
      toggleDropdown(buttonContainer);
  }
  
  // Fonction pour fermer la liste déroulante si le clic est à l'extérieur
    function closeDropdownIfOutside(event, dropdownSelector) {
      if (!$(event.target).closest(dropdownSelector).length) {
          $(dropdownSelector).removeClass("active");
      }
  }
  
  // Fonction pour lier les événements aux boutons des listes déroulantes
  function bindDropdownEvents(mainButtonSelector, dropdownSelector) {
      const mainDropdownButton = $(mainButtonSelector);
      mainDropdownButton.click(function () {
          toggleDropdown($(this).parent());
      });
  
      const dropdownItems = $(`${dropdownSelector} .dropdown-item`);
      dropdownItems.click(function () {
          const label = $(this).text();
          const value = $(this).data("value");
          selectOption($(this), label, value);
      });
  }
  
  // Fonction pour filtrer les cards en fonction des valeurs sélectionnées
  function filterPosts(selectedCategory, selectedFormat, sortType) {
      console.log(sortType);
      $.ajax({
          url: ajaxurl,
          type: "POST",
          data: {
              action: "filter_posts",
              category: selectedCategory,
              format: selectedFormat,
              sortType: sortType,
          },
          success: function (response) {
            // Mise à jour du contenu de la div avec les résultats filtrés
              $("#post-container").html(response);
              resetLoadMore();
          },
          error: function (error) {
              console.error("Erreur AJAX :", error);
          },
      });
  }
