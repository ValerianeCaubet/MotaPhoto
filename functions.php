<?php

///////////////////////// ADD CSS /////////////////////////////
///////////////////////////////////////////////////////////////


function enqueue_custom_styles() {
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/scss/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');


///////////////////// ADD JQUERY AND JSCRIPT //////////////////////
////////////////////////////////////////////////////////////////////

function script_JS_Custom() {

    // Ajout de jQuery
    wp_enqueue_script('jquery-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '3.7.1', true);

    // Gestion de la Modale (script jQuery)
    wp_enqueue_script('modale', get_stylesheet_directory_uri() . '/js/modale.js', array('jquery'), '1.0.0', true);

    // Affichage des images miniature (script JQuery)
    wp_enqueue_script('singleMiniature', get_stylesheet_directory_uri() . '/js/single-photo.js', array('jquery'), '1.0.0', true);


}

add_action('wp_enqueue_scripts', 'script_JS_Custom');

// Ajouter le script pour les appels AJAX
function enqueue_ajax_script() {
    // Enregistrer le script ajax.js dans le thème
    wp_enqueue_script('ajax-script', get_template_directory_uri() . '/js/ajax.js', array('jquery'));

    // Localiser le script ajax.js pour que nous puissions obtenir l'URL admin-ajax.php
    wp_localize_script('ajax-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_script');

//////////////////////// MENUS REGISTER /////////////////////////
/////////////////////////////////////////////////////////////////

function register_menus() {
    register_nav_menus(
        array(
            'header-menu' => 'menu header',
            'footer-menu' => 'menu footer'
        )
    );
}
add_action('init', 'register_menus');



//////////////////////////// BOUTON LOAD MORE //////////////////////////////
///////////////////////////////////////////////////////////////////////////

/// Enregistrer le script JavaScript pour la fonctionnalité "Charger plus"
function custom_load_more_scripts() {
    wp_enqueue_script('custom-load-more', get_template_directory_uri() . '/js/ajax.js', array('jquery'), null, true);

    // Passer la variable ajaxurl à JavaScript
    wp_localize_script('custom-load-more', 'load_more_params', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'posts_per_page' => 8, // Nombre de posts à charger à chaque fois
    ));
}
add_action('wp_enqueue_scripts', 'custom_load_more_scripts');

// Fonction pour charger plus de photos avec AJAX
function custom_load_more_posts() {
    // Débogage - Vérifier les données reçues
    error_log('Données reçues : ' . print_r($_POST, true));

    $page = isset($_POST['paged']) ? $_POST['paged'] : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? $_POST['posts_per_page'] : 6; // Nombre de posts par page

    // Débogage - Vérifier les valeurs de page et de posts_per_page
    error_log('Page : ' . $page . ', Posts par page : ' . $posts_per_page);

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
    );

    // Débogage - Vérifier les arguments de la requête WP_Query
    error_log('Arguments de la requête WP_Query : ' . print_r($args, true));

    $all_photos = new WP_Query($args);

    ob_start();

    if ($all_photos->have_posts()) {
        while ($all_photos->have_posts()) {
            $all_photos->the_post();
            // Inclure le fichier de modèle photo-part.php
            get_template_part('template-part/photo-part');
        }
    }

    $response = ob_get_clean();

    // Débogage - Vérifier la réponse générée
    error_log('Réponse générée : ' . $response);

    // Renvoyer la réponse
    echo $response;

    wp_die();
}
add_action('wp_ajax_load_more_posts', 'custom_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'custom_load_more_posts');

//////////////////////////////// FILTRES ////////////////////////////////
/////////////////////////////////////////////////////////////////////////


add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');

function filter_posts() {
   // Récupérer les valeurs filtrées de la requête AJAX
   $selectedCategory = isset($_POST['category']) ? $_POST['category'] : '';
   $selectedFormat = isset($_POST['format']) ? $_POST['format'] : '';
   $sortType = isset($_POST['sortType']) ? $_POST['sortType'] : '';

   // Construire les arguments de la requête WP_Query en fonction des filtres
   $args = array(
      'post_type' => 'photo',
      'posts_per_page' => 8, // Afficher 8 posts max
      'paged' => 1 // pagination
   );

   // Ajouter la taxonomie "categories" si elle est sélectionnée
   if (!empty($selectedCategory)) {
      $args['tax_query'][] = array(
         'taxonomy' => 'categorie',
         'field' => 'slug',
         'terms' => $selectedCategory,
      );
   }

   // Ajouter la taxonomie "formats" si elle est sélectionnée
   if (!empty($selectedFormat)) {
      $args['tax_query'][] = array(
         'taxonomy' => 'formats',
         'field' => 'slug',
         'terms' => $selectedFormat,
      );
   }

   // Ajouter le tri par date si spécifié
   if (!empty($sortType)) {
      if ($sortType === 'asc') {
          $args['orderby'] = 'date';
          $args['order'] = 'ASC';
      } elseif ($sortType === 'desc') {
          $args['orderby'] = 'date';
          $args['order'] = 'DESC';
      }
   }

   // Effectuer la requête WP_Query
   $query = new WP_Query($args);

   // Charger le template des cards avec les résultats filtrés
   if ($query->have_posts()) :
      while ($query->have_posts()) : $query->the_post();
         get_template_part('template-part/photo-part');
      endwhile;
   else :
      echo 'Aucune photo ne correspond à votre recherche.';
   endif;
   wp_reset_postdata();
   die(); // Arrêter l'exécution après avoir renvoyé les résultats
}



//////////////////////// ADD FANCYBOX - LIGHTBOX ///////////////////////////
///////////////////////////////////////////////////////////////////////////

function enqueue_fancybox() {
    // Inclure le CSS de Fancybox
    wp_enqueue_style('fancybox-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css');

    // Inclure le JavaScript de Fancybox
    wp_enqueue_script('fancybox-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array('jquery'), null, true);

    // Initialiser Fancybox
    wp_add_inline_script('fancybox-js', '
    function initFancybox() {
        jQuery(".fancybox").fancybox({
            buttons : [
                "close"
            ],
            showNavArrows : false,
            arrows : false,
            infobar: false,
            touch: false,
            loop: true,
            clickContent: false,
            baseClass: "fancybox-custom-layout",
            afterShow: function(instance, slide) {
                console.log("Fancybox is working!");
            }
        });
    }

    jQuery(document).ready(function() {
        initFancybox();
    });

    jQuery(document).ajaxComplete(function() {
        initFancybox();
    });
');
}
add_action('wp_enqueue_scripts', 'enqueue_fancybox');



?>