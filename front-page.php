<?php get_header(); ?>

<!-------------------------- HERO HEADER  ------------------------>
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


    <!-- ------------------------------- LIST FILTERS ----------------------- -->
    
    <div class="filters-container">

        <div class="selects-taxonomies">

            <!-- liste deroulante Catégories -->
            <div class="custom-dropdown" id="select-categories">
                <!-- Bouton déclencheur de la liste déroulante -->
                <button class="dropdown-button" id="mainDropdownButtonCategories">CATÉGORIES</button>
                <!-- Contenu de la liste déroulante -->
                <div class="dropdown-content">
                    <!-- Bouton initial sans valeur utilisé comme titre -->
                    <button class="dropdown-item dropdown-item--title-colors" data-value="">Catégories</button>
                    <!-- Récupére tous les termes de la taxonomie 'categorie-photo'-->
                    <?php $fields = get_terms(array('taxonomy' => 'categorie-photo')); ?>
                    <!-- Vérifie s'il y a des termes (catégories) disponibles -->
                    <?php if ($fields): ?>
                        <!-- Pour chaque terme (catégorie) obtenu -->
                        <?php foreach ($fields as $value): ?>
                            <!-- Vérifie si le terme (catégorie) a un slug et un nom définis  -->
                            <?php if ($value && isset($value->slug) && isset($value->name)): ?>
                                <!-- Affiche un bouton représentant chaque catégorie et stocke dans data-value le slug et le nom correspondant -->
                                <button class="dropdown-item" data-value="<?= $value->slug ?>"><?= $value->name ?></button>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

    <!-- ------------------------FORMATS----------------------------- -->
            <!-- liste deroulante Formats -->
            <div class="custom-dropdown" id="select-formats">
                <button class="dropdown-button" id="mainDropdownButtonFormats">FORMATS</button>
                <div class="dropdown-content">
                    <button class="dropdown-item dropdown-item--title-colors" data-value="">Formats</button>
                    <?php $fields = get_terms(array('taxonomy' => 'format')); ?>
                    <?php if ($fields): ?>
                        <?php foreach ($fields as $value): ?>
                            <?php if ($value && isset($value->slug) && isset($value->name)): ?>
                                <button class="dropdown-item" data-value="<?= $value->slug ?>"><?= $value->name ?></button>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    <!-- -------------------------DATE------------------------------ -->
        <!-- liste deroulante date -->

        <div class="custom-dropdown" id="select-by-date">
            <button class="dropdown-button" id="mainDropdownButtonDate">TRIER PAR</button>
                <div class="dropdown-content">
                    <button class="dropdown-item dropdown-item--title-colors" data-value="">Trier par</button>
                    <button class="dropdown-item" data-value="desc">Plus récents</button>
                    <button class="dropdown-item" data-value="asc">Plus anciens</button>
                </div>
        </div>
</div>


<?php
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

 <!-- -------------------------LOAD MORE BUTTON------------------------------ -->

<div class="load-more-btn-container">
        <button id="load-more-btn" class="load-more">Charger plus</button>
        <p id="load-more-message"></p>
        </div>
</section>


</div>
<!-- footer -->
<?php get_footer(); ?>