<?php
/**
 * The 404 template
 *
 * @package Fotka
 */

get_header();
?>

<div class="site-content">
    <main class="content-area">
        <div class="error-404">
            <h1 class="page-title"><?php _e('404 - Strona nie znaleziona', 'fotka'); ?></h1>
            <div class="page-content">
                <p><?php _e('Przepraszamy, ale strona której szukasz nie istnieje.', 'fotka'); ?></p>
                
                <h2><?php _e('Spróbuj wyszukać:', 'fotka'); ?></h2>
                <?php get_search_form(); ?>
                
                <h2><?php _e('Lub przeglądaj kategorie:', 'fotka'); ?></h2>
                <ul class="categories-list">
                    <?php
                    wp_list_categories(array(
                        'title_li'    => '',
                        'show_count'  => true,
                        'number'      => 10,
                    ));
                    ?>
                </ul>
                
                <p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
                        <?php _e('Powrót na stronę główną', 'fotka'); ?>
                    </a>
                </p>
            </div>
        </div>
    </main>
    
    <?php get_sidebar(); ?>
</div>

<?php
get_footer();
