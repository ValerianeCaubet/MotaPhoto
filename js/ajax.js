 
  /////////////////////////// LOAD MORE BUTTON /////////////////////

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
