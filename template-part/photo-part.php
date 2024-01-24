<div class="suggested-photo">
    
        <img class="photo-template" src="<?php
                    $photo = get_field('photo');
                    echo $photo['url'];
                    ?>" alt="photographie">
    
    <div class="overlay">

        <div class="overlay-fullscreen">
            <?php
            $title = get_the_title();
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $category_names = array();
            foreach ( (array) $categories as $category ) {
                $category_names[] = $category->name;
            }
            // contenu de l' affichage de la lightbox
            $photo_ref = get_field('reference'); 
            $caption = '<h2>' . $photo_ref . '</h2><p>' . implode(', ', $category_names) . '</p>';
            ?>
            
        </div>
    </div>

</div>