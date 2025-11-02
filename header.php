<?php
/**
 * The header template
 *
 * @package Fotka
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="site-container">
        <div class="header-wrapper">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                    <?php
                }
                ?>
            </div>
            
            <div class="header-social-links">
                <span><?php _e('Znajdź nas na:', 'fotka'); ?></span>
                <?php fotka_display_social_links('header'); ?>
            </div>
        </div>
    </div>
</header>

<div class="site-container">
