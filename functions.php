<?php

///////////////////////// ADD CSS /////////////////////////////
function enqueue_custom_styles() {
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/scss/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');


///////////////////// ADD JQUERY AND JS SCRIPT //////////////////////
function script_JS_Custom() {

    // Ajout de jQuery
    wp_enqueue_script('jquery-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '3.7.1', true);

    // Gestion de la Modale (script jQuery)
    wp_enqueue_script('modale', get_stylesheet_directory_uri() . '/js/modale.js', array('jquery'), '1.0.0', true);

    // Affichage des images miniature (script JQuery)
    wp_enqueue_script('singleMiniature', get_stylesheet_directory_uri() . '/js/single-photo.js', array('jquery'), '1.0.0', true);

    // Affichage des images miniature (script JQuery)
    wp_enqueue_script('ajax', get_stylesheet_directory_uri() . '/js/ajax.js', array('jquery'), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'script_JS_Custom');

//////////////////////// MENUS REGISTER /////////////////////////
function register_menus() {
    register_nav_menus(
        array(
            'header-menu' => 'menu header',
            'footer-menu' => 'menu footer'
        )
    );
}
add_action('init', 'register_menus');


//////////////////// BOUTON LOAD MORE ///////////////////////


function load_more_posts() {
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 12,
        'ignore_sticky_posts' => 1,
        'paged' => $_POST['page'],
    );
  
    // Ajouter la taxonomie "categorie-photo" si elle est sélectionnée
    if (!empty($_POST['category'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie-photo',
            'field' => 'slug',
            'terms' => $_POST['category'],
        );
    }
  
    // Ajouter la taxonomie "format" si elle est sélectionnée
    if (!empty($_POST['format'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $_POST['format'],
        );
    }
  
  
      // Ajouter le tri par date si spécifié
      if (!empty($_POST['sortType'])) {
        if ($_POST['sortType'] === 'asc') {
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = 'annee';
            $args['meta_type'] = 'DATE';
            $args['order'] = 'ASC';
        } elseif ($_POST['sortType'] === 'desc') {
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = 'annee';
            $args['meta_type'] = 'DATE';
            $args['order'] = 'DESC';
        }
    }
  
    $query = new WP_Query($args);
  
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // code pour afficher chaque carte
            get_template_part('template-part/photo-part');
        endwhile;
        //wp_reset_postdata();
    else :
        echo 'no-more-posts';
    endif;
    wp_reset_postdata();
    die();
  }
  
  add_action('wp_ajax_load_more_posts', 'load_more_posts');
  add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');
  
  function add_ajax_url_to_front() {
    ?>
    <script>
        var ajaxurl = '<?php echo site_url('/wp-admin/admin-ajax.php'); ?>';
    </script>
    <?php
  }
  
  add_action('wp_head', 'add_ajax_url_to_front');
  

//////////////////////// ADD FANCYBOX - LIGHTBOX ///////////////////////////
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