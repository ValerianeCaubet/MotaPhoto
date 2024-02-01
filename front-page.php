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

<div class="page-container">

<!-- Affichage des photos -->
<div id="more_posts" class="photo-suggestions">    
</div>

<div id="more_photos" class="photo-suggestions">
</div>


</div>
<!-- footer -->
<?php get_footer(); ?>