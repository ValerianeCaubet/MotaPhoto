<!DOCTYPE html>
<html <?php language_attributes(); ?>> 

<head>
    <meta charset="<?php bloginfo('charset'); ?>"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<header class="header">
    <div class="header-container">
        <div class="logo">
            <a href="<?php echo home_url('/'); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>./assets/img/logo-mota.png" alt="Logo">
            </a>
        </div>
        <nav class="nav-link">
            <?php
                wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'menu_class' => 'header-menu', // classe CSS pour customiser mon menu
                ));
            ?>
        </nav>
    </div>
</header>