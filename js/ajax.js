 
  /////////////////////////// LOAD MORE BUTTON /////////////////////
  
  var page = 2; // Page actuelle, initialisée à 2 car première page déjà chargée
  var loading = false; // Variable pour éviter le chargement simultané de plusieurs pages
  var buttonHidden = false; // Variable pour suivre si le bouton a été masqué
  // Écouteur d'événements sur le bouton "Charger plus"
  $("#load-more-btn").on("click", function () {
    if (!loading) { // Vérifie si le chargement est déjà en cours
      loading = true; // Met à jour la variable pour indiquer que le chargement commence
      // Récupérer les valeurs de filtres actuelles
      const selectedCategory = $("#select-categories .selected-option").data(
      "value"
      );
      const selectedFormat = $("#select-formats .selected-option").data(
        "value"
      );
      const sortType = $("#select-by-date .selected-option").data("value");
      //console.log(sortType);
      // Appel AJAX pour récupérer davantage de posts
      $.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
        action: "load_more_posts",
        page: page,
        category: selectedCategory,
        format: selectedFormat,
        sortType: sortType,
        },
        success: function (response) { // Vérifie si la réponse contient plus de posts
        if (response !== "no-more-posts") {
          // Ajoute les nouveaux posts au conteneur existant
          $("#post-container").append(response);
          page++; // Incrémente le numéro de page pour la prochaine requête
        } else {
          // Affiche un message s'il n'y a plus de posts à charger
            $("#load-more-message").text("Il n'y a plus d'autres photos à afficher.");
            if (!buttonHidden) { // Ne masquera le bouton que s'il n'a pas été masqué auparavant
            $("#load-more-btn").hide(); // Cache le bouton s'il n'y a plus de posts
            buttonHidden = true; // Met à jour la variable pour indiquer que le bouton a été masqué
            }
          }
            loading = false; // Met à jour la variable pour indiquer que le chargement est terminé
        },
      });
    }
  });
  
  // Remet à zéro l'etat du bouton load more
  const resetLoadMore = () => {
  page = 2; // Réinitialise le numéro de page
  loading = false; // Réinitialise la variable de chargement
  buttonHidden = false; // Réinitialise la variable de bouton masqué
  $("#load-more-btn").show(); // Affiche le bouton
  $("#load-more-message").text(""); // Efface le message
  }