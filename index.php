<?php
/**
 * The main template file
 *
 * @package Fotka
 */

get_header();
?>

<div class="site-content">
    <main class="content-area">
        <?php if (have_posts()) : ?>
            
            <div class="posts-masonry">
                <?php 
                $post_counter = 0;
                while (have_posts()) : 
                    the_post(); 
                    $post_counter++;
                    $is_featured = ($post_counter === 1); // Pierwszy post jest wyróżniony
                    ?>
                    <?php get_template_part('template-parts/content', 'card', array('featured' => $is_featured)); ?>
                <?php endwhile; ?>
            </div>
            
            <?php
            // Paginacja
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('« Poprzednie', 'fotka'),
                'next_text' => __('Następne »', 'fotka'),
            ));
            ?>
            
        <?php else : ?>
            
            <div class="no-posts">
                <h2><?php _e('Brak wpisów', 'fotka'); ?></h2>
                <p><?php _e('Nie znaleziono żadnych wpisów.', 'fotka'); ?></p>
            </div>
            
        <?php endif; ?>
    </main>
    
    <?php get_sidebar(); ?>
</div>

<?php
get_footer();
