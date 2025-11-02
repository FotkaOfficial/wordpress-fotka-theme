<?php
/**
 * The archive template
 *
 * @package Fotka
 */

get_header();
?>

<div class="site-content">
    <main class="content-area">
        <?php if (have_posts()) : ?>
            
            <header class="archive-header">
                <h1 class="archive-title">
                    <?php
                    if (is_category()) {
                        single_cat_title();
                    } elseif (is_tag()) {
                        single_tag_title();
                    } elseif (is_author()) {
                        the_author();
                    } elseif (is_day()) {
                        echo get_the_date();
                    } elseif (is_month()) {
                        echo get_the_date('F Y');
                    } elseif (is_year()) {
                        echo get_the_date('Y');
                    } else {
                        _e('Archiwum', 'fotka');
                    }
                    ?>
                </h1>
                <?php
                if (is_category() && category_description()) {
                    echo '<div class="archive-description">' . category_description() . '</div>';
                }
                ?>
            </header>
            
            <div class="posts-masonry">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'card'); ?>
                <?php endwhile; ?>
            </div>
            
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('« Poprzednie', 'fotka'),
                'next_text' => __('Następne »', 'fotka'),
            ));
            ?>
            
        <?php else : ?>
            
            <div class="no-posts">
                <h2><?php _e('Brak wpisów', 'fotka'); ?></h2>
                <p><?php _e('Nie znaleziono żadnych wpisów w tym archiwum.', 'fotka'); ?></p>
            </div>
            
        <?php endif; ?>
    </main>
    
    <?php get_sidebar(); ?>
</div>

<?php
get_footer();
