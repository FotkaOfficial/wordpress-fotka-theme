<?php
/**
 * The search template
 *
 * @package Fotka
 */

get_header();
?>

<div class="site-content">
    <main class="content-area">
        <header class="search-header">
            <h1 class="search-title">
                <?php
                printf(
                    __('Wyniki wyszukiwania dla: %s', 'fotka'),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </header>
        
        <?php if (have_posts()) : ?>
            
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
                <h2><?php _e('Nic nie znaleziono', 'fotka'); ?></h2>
                <p><?php _e('Spróbuj wyszukać coś innego.', 'fotka'); ?></p>
                <?php get_search_form(); ?>
            </div>
            
        <?php endif; ?>
    </main>
    
    <?php get_sidebar(); ?>
</div>

<?php
get_footer();
