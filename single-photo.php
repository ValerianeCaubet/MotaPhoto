<!-- Template pour l' affichage d' une seul post et ses détails (ici uniquement pour les photos) -->

<?php get_header(); ?>

<?php while (have_posts()) : the_post() ?>
    <?php
    global $wp_query;
    ?>

    <div class="page-container">
        <div class="part-container"> 

        <!-- section détail photo -->
        <section class="main-content">
            <div class="content-body">
                <div class="title-type">
                    <h1 class="pic-title"><?php echo get_the_title() ?></h1>
                    <p>Référence : <span class="ref-val"><?php echo get_field('reference'); ?></span></p>
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'categorie');
                    $formats = get_the_terms(get_the_ID(), 'formats');

                    if ($categories && !is_wp_error($categories)) {
                        $category_names = wp_list_pluck($categories, 'name');
                        echo '<p>Catégorie : ' . implode(', ', $category_names) . '</p>';
                    }

                    if ($formats && !is_wp_error($formats)) {
                        $format_names = wp_list_pluck($formats, 'name');
                        echo '<p>Format : ' . implode(', ', $format_names) . '</p>';
                    }
                    ?>


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
                    <div class="preview" id="current-preview">
                        <?php
                        $currentThumbnail = get_field("photo");
                        $currentLink = get_permalink();
                        ?>
                        <a href="<?= $currentLink; ?>">
                            <img id="current-image" class="current-image" src="<?php echo $currentThumbnail["sizes"]["thumbnail"]; ?>" alt="Prévisualisation image actuelle">
                        </a>
                    </div>

                    <div class="preview" id="previous-preview">
                        <?php if (!empty($prevPost)) :
                            $prevThumbnail = get_field("photo", $prevPost->ID);
                            $prevLink = get_permalink($prevPost); ?>
                            <a href="<?= $prevLink; ?>">
                                <img id="previous-image" class="previous-image" src="<?php echo $prevThumbnail["sizes"]["thumbnail"]; ?>" alt="Prévisualisation image précédente">
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="preview" id="next-preview">
                        <?php if (!empty($nextPost)) :
                            $nextThumbnail = get_field("photo", $nextPost->ID);
                            $nextLink = get_permalink($nextPost); ?>
                            <a href="<?= $nextLink; ?>">
                                <img id="next-image" class="next-image" src="<?php echo $nextThumbnail["sizes"]["thumbnail"]; ?>" alt="Prévisualisation image suivante">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
         </div>
        </section>
<!-- section photos apparentées -->
<section class="suggested-photo-container">       
    <h3>Vous aimerez AUSSI</h3>

    <div class="photo-suggestions">
        <?php
        // Récupérer les deux premières photos de la même catégorie (sauf la photo actuelle)
        $args = array(
            'post_type'      => 'photo',
            'posts_per_page' => 2,
            'orderby'        => 'rand',
            'post__not_in'   => array($post->ID),
            'tax_query'      => array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'slug',
                    'terms'    => $categories ? $categories[0]->slug : [],
                ),
            ),
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                // Vérifier si la photo a une vignette avant de l'afficher
                if (has_post_thumbnail()) {
                    get_template_part('template-part/photo-part');
                }
            }
            // Réinitialiser les données post
            wp_reset_postdata();
        }
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
