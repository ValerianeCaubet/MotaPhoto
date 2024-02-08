<?php get_header(); ?>

<!-- Hero -->
<section class="hero">
<?php
    // arguments de la requête
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 1, 
        'orderby' => 'rand',
    );

    // création d' une nouvelle instance de WP_Query
    $query = new WP_Query($args);

    // boucle sur les résultats
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
                <img src="<?php
                    $photo = get_field('photo');
                    echo $photo['url'];
                    ?>" alt="photographie">
            <?php
        }
    }
    // réinitialisation de la requête
    wp_reset_postdata();
    ?>
<h1>PHOTOGRAPHE EVENT</h1>
</section>

<div class="page-container-front">

<?php
// Fonction pour afficher le bloc de photo
function display_photo_block($photo) {
    $photo_image = get_field('photo', $photo->ID);
    $photo_ref = get_field('reference', $photo->ID);
    
    // Récupérer les catégories et vérifier si elles existent
    $categories = get_the_terms($photo->ID, 'categorie');
    $category_names = array();
    
    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_names[] = $category->name;
        }
    }

    $caption = '<h2>' . $photo_ref . '</h2><p>' . implode(', ', $category_names) . '</p>';
    ?>

    <div class="suggested-photo">
        <img class="photo-template" src="<?php echo $photo_image['url']; ?>" alt="photographie">

        <div class="overlay">
            <div class="overlay-fullscreen">
                <a href="<?php echo $photo_image['url']; ?>" class="fancybox" data-fancybox="gallery" data-caption="<?php echo esc_attr($caption); ?>">
                    <img src="<?php echo get_template_directory_uri()?>/assets/img/Icon_fullscreen.png" alt="">
                </a>
            </div>

            <div class="overlay-single">
                <a href="<?php echo get_permalink($photo->ID); ?>">
                    <img src="<?php echo get_template_directory_uri()?>/assets/img/Icon_eye.png" alt="">
                </a>
            </div>

            <div class="overlay-text">
                <p class="overlay-title"><?php echo get_the_title($photo->ID); ?></p>
                <p class="overlay-category"><?php echo implode(', ', $category_names); ?></p>
            </div>
        </div>
    </div>
    <?php
}

// Modifier la requête WordPress pour obtenir tous les posts de type "photo"
$args = array(
  'post_type'      => 'photo',
  'posts_per_page' => 8, // Afficher 8 posts max
);

$all_photos = get_posts($args);

// Boucle pour afficher tous les blocs de photos
foreach ($all_photos as $photo) : setup_postdata($photo);
    display_photo_block($photo);
endforeach;

// Réinitialiser la requête postdata
wp_reset_postdata();
?>






</div>
<!-- footer -->
<?php get_footer(); ?>