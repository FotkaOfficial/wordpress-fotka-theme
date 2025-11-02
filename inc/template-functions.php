<?php
/**
 * Template Functions
 *
 * @package Fotka
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Pobierz powiązane posty
 */
function fotka_get_related_posts($post_id, $limit = 3) {
    $categories = wp_get_post_categories($post_id);
    
    $args = array(
        'category__in'        => $categories,
        'post__not_in'        => array($post_id),
        'posts_per_page'      => $limit,
        'ignore_sticky_posts' => 1,
        'orderby'             => 'rand',
    );
    
    return new WP_Query($args);
}

/**
 * Pobierz popularne posty
 */
function fotka_get_popular_posts($limit = 5, $days = 30) {
    $args = array(
        'posts_per_page'      => $limit,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby'             => 'comment_count',
        'order'               => 'DESC',
    );
    
    if ($days > 0) {
        $args['date_query'] = array(
            array(
                'after' => date('Y-m-d', strtotime("-{$days} days")),
            ),
        );
    }
    
    return new WP_Query($args);
}
