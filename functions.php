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