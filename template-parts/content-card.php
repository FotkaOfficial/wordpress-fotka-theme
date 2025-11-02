<?php
/**
 * Template part for displaying post card
 *
 * @package Fotka
 */

$is_featured = isset($args['featured']) && $args['featured'];
$card_class = $is_featured ? 'post-card post-card-featured' : 'post-card';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($card_class); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-card-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('fotka-card'); ?>
            </a>
            <?php
            $categories = get_the_category();
            if (!empty($categories)) :
                ?>
                <span class="post-card-category">
                    <?php echo esc_html($categories[0]->name); ?>
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <div class="post-card-content">
        <h2 class="post-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        
        <div class="post-card-excerpt">
            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
        </div>
        
        <div class="post-card-meta">
            <?php echo get_the_date(); ?>
        </div>
    </div>
</article>
