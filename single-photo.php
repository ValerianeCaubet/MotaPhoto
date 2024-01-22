<!-- Template pour l' affichage d' une seul post et ses détails (ici uniquement pour les photos) -->

<?php get_header(); ?>

<?php while (have_posts()) : the_post() ?>
    <?php
    global $wp_query;
    ?>

    <div class="page-container">

        <!-- section détail photo -->
        <section class="main-content">
            <div class="content-body">
                <div class="title-type">
                    <h1 class="pic-title"><?php echo get_the_title() ?></h1>
                    <p>Référence : <span class="ref-val"><?php echo get_field('reference'); ?></span></p>
                    <p>Catégorie : <?php the_terms(get_the_ID(), 'Categories', 'Aucune catégorie'); ?></p>
                    <p>Format : <?php the_terms(get_the_ID(), 'Formats', 'Aucun format'); ?></p>
                    <p>Type : <?php echo get_field('type'); ?></p>
                    <p>Année : <?php echo get_field('annees'); ?></p>
                </div>

                <div class="photo-container">
                    <img src="<?php
                                $photo = get_field('photo');
                                echo $photo['url'];
                                ?>" alt="photographie">
                </div>
            </div>
        </section>  
        
        <!-- section contact et carrousel miniature -->
        <section class="contact-carrousel">
            
            <div class="contact-btn">
                <h4>Cette photo vous intéresse ?</h4>
                <button id="boutonContact">Contact</button>
            </div> 

            <div class="interaction-photo__navigation">
                <?php
                    $prevPost = get_previous_post();
                    $nextPost = get_next_post();
                ?>

                <div class="arrows">
                    <?php if (!empty($prevPost)) :                        
                            $prevLink = get_permalink($prevPost); ?>
                            <a id="arrow-left" href="<?= $prevLink; ?>">
                                <img class="arrow arrow-gauche" src="<?= get_template_directory_uri(); ?>/assets/img/left.png" alt="Flèche pointant vers la gauche" />
                            </a>
                            <?php endif;
                            if (!empty($nextPost)) :
                                $nextLink = get_permalink($nextPost); ?>
                                <a href="<?= $nextLink; ?>">
                                    <img id="arrow-right" class="arrow arrow-droite" src="<?= get_template_directory_uri(); ?>/assets/img/right.png" alt="Flèche pointant vers la droite" />
                                </a>
                    <?php endif; ?>
                </div>
                
                <div class="div-preview">
                    <div class="preview">
                        <?php if (!empty($prevPost)) :
                                $prevThumbnail = get_field( "photo" , $prevPost->ID );
                                $prevLink = get_permalink($prevPost); ?>
                                <a href="<?= $prevLink; ?>">
                                <img id="previous-image" class="previous-image" src="<?php echo $prevThumbnail["sizes"]["thumbnail"]; ?>" alt="Prévisualisation image précédente">
                                </a>
                        <?php endif; ?>
                    </div>

                    <div class="preview">
                        <?php if (!empty($nextPost)) :
                                    $nextThumbnail = get_field( "photo" , $nextPost->ID );                  
                                    $nextLink = get_permalink($nextPost);                            
                                    ?>
                                    <a href="<?= $nextLink; ?>">
                                    <img id="next-image" class="next-image" src="<?php echo $nextThumbnail["sizes"]["thumbnail"]; ?>" alt="Prévisualisation image suivante">
                                    </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- section photos apparentées -->
        <section class="suggested-photo-container">       
            <h3>Vous aimerez AUSSI</h3>
        
            <div class="photo-suggestions">
                <!-- récupération des photos de même catégorie avec WP_query -->
                <?php
                // arguments de la requête

                $args = array(
                    'post_type' => 'photo',
                    'posts_per_page' => 2,
                    'orderby' => 'rand',
                    'post__not_in' => array(get_the_ID()),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'Categories',
                            'field' => 'slug',
                            'terms' => $category_slug,
                        ),
                    ),
                );


                // création d' une nouvelle instance de WP_Query
                $query = new WP_Query($args);

                // boucle sur les résultats
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        ?>
                        <?php get_template_part('template-part/photo-part'); ?>
                        <?php
                    }
                }
                // réinitialisation de la requête
                wp_reset_postdata();
                ?>
            </div>

            <div class="all-photos-btn">
                <a href="<?php echo home_url(); ?>">
                    <button id="button-photos">Toutes les photos</button>
                </a>
            </div>

        </section>
    </div>

<?php endwhile ?>
<?php get_footer(); ?>