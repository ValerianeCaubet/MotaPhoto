<?php

// Ajout des styles 
function enqueue_custom_styles() {
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/scss/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

// Ajout de jQuery d'un CDN et des scripts JS personnalisés
function script_JS_Custom() {
    // Ajout de jQuery
    wp_enqueue_script('jquery-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '3.7.1', true);

    // Gestion de la Modale (script jQuery)
    wp_enqueue_script('modale', get_stylesheet_directory_uri() . '/js/modale.js', array('jquery'), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'script_JS_Custom');

// Enregistrement des menus
function register_menus() {
    register_nav_menus(
        array(
            'header-menu' => 'menu header',
            'footer-menu' => 'menu footer'
        )
    );
}
add_action('init', 'register_menus');


?>