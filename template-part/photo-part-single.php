<div class="suggested-photo-single">
<img class="photo-template-single" src="<?php
                                $photo = get_field('photo');
                                echo $photo['url'];
                                ?>" alt="photographie">

    <div class="overlay-single">
        <div class="overlay-fullscreen-single">
            <?php
            $title = get_the_title();
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $category_names = array();
            foreach ((array)$categories as $category) {
                $category_names[] = $category->name;
            }
            // Contenu de l'affichage de la lightbox
            $photo_ref = get_field('reference');
            $caption = '<h2>' . $photo_ref . '</h2><p>' . implode(', ', $category_names) . '</p>';
            ?>
            <a href="<?php echo $photo['url']; ?>" class="fancybox" data-fancybox="gallery" data-caption="<?php echo esc_attr($caption); ?>">
                <img src="<?php echo get_template_directory_uri() ?>/assets/img/Icon_fullscreen.png" alt="">
            </a>
        </div>

        <div class="overlay-text-single">
            <p class="overlay-title-single"><?php echo get_the_title() ?></p>
            <p class="overlay-category-single">
                <?php
                $categories = get_the_terms(get_the_ID(), 'categorie');
                foreach ((array)$categories as $category) {
                    echo $category->name . ' ';
                }
                ?>
            </p>
        </div>
    </div>
</div>
