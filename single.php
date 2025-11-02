<?php
/**
 * The single post template
 *
 * @package Fotka
 */

get_header();
?>

<div class="site-content">
    <main class="content-area">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <?php
                        printf(
                            __('%s', 'fotka'),
                            get_the_date()
                        );
                        ?>
                    </div>
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                
                <footer class="entry-footer">
                    <?php
                    // Tagi
                    $tags = get_the_tags();
                    if ($tags) {
                        ?>
                        <div class="post-tags">
                            <strong><?php _e('Tagi:', 'fotka'); ?></strong>
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <?php
                    }
                    ?>
                    
                    <div class="social-share">
                        <span><?php _e('Udostępnij:', 'fotka'); ?></span>
                        <?php fotka_display_social_share(); ?>
                    </div>
                </footer>
            </article>
            
            <?php
            // Powiązane posty
            $related_posts = fotka_get_related_posts(get_the_ID(), 3);
            if ($related_posts->have_posts()) :
                ?>
                <div class="related-posts">
                    <h3><?php _e('Może ci się spodobać również', 'fotka'); ?></h3>
                    <div class="related-posts-grid">
                        <?php
                        while ($related_posts->have_posts()) :
                            $related_posts->the_post();
                            get_template_part('template-parts/content', 'card');
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <?php
            endif;
            ?>
            
        <?php
        endwhile;
        ?>
    </main>
    
    <?php get_sidebar(); ?>
</div>

<?php
get_footer();
