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
                    <!-- Récupére tous les termes de la taxonomie 'categorie'-->
                    <?php $fields = get_terms(array('taxonomy' => 'categorie')); ?>
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
                    <?php $fields = get_terms(array('taxonomy' => 'formats')); ?>
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



// Modifier la requête WordPress pour obtenir tous les posts de type "photo"

 

$args = array(
  'post_type'      => 'photo',
  'posts_per_page' => 2, // Afficher 8 posts max
  'paged' => 1 // pagination
);

// création d' une nouvelle instance de WP_Query
$query = new WP_Query($args);

// boucle sur les résultats
if ($query->have_posts()) ?> <div id="post-container"> <?php {
   
    while ($query->have_posts()) {
        $query->the_post();
        ?>
          
        <?php
         get_template_part('template-part/photo-part');
    } ?> </div>
<?php }


// Réinitialiser la requête postdata
wp_reset_postdata();
?>

</div>

 <!-- -------------------------LOAD MORE BUTTON------------------------------ -->

<div class="load-more-btn-container">
        <button id="load-more-btn" class="load-more">Charger plus</button>
        <p id="load-more-message"></p>
        </div>
</section>


</div>
<!-- footer -->
<?php get_footer(); ?>