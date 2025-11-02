<?php
/**
 * Social Media Functions
 *
 * @package Fotka
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Dostępne platformy social media
 */
function fotka_get_available_social_platforms() {
    return array(
        'facebook' => array(
            'name' => 'Facebook',
            'icon' => 'fab fa-facebook-f',
            'share_url' => 'https://www.facebook.com/sharer/sharer.php?u=',
        ),
        'twitter' => array(
            'name' => 'Twitter',
            'icon' => 'fab fa-twitter',
            'share_url' => 'https://twitter.com/intent/tweet?url=',
        ),
        'instagram' => array(
            'name' => 'Instagram',
            'icon' => 'fab fa-instagram',
            'share_url' => '',
        ),
        'linkedin' => array(
            'name' => 'LinkedIn',
            'icon' => 'fab fa-linkedin-in',
            'share_url' => 'https://www.linkedin.com/shareArticle?mini=true&url=',
        ),
        'youtube' => array(
            'name' => 'YouTube',
            'icon' => 'fab fa-youtube',
            'share_url' => '',
        ),
        'tiktok' => array(
            'name' => 'TikTok',
            'icon' => 'fab fa-tiktok',
            'share_url' => '',
        ),
        'pinterest' => array(
            'name' => 'Pinterest',
            'icon' => 'fab fa-pinterest-p',
            'share_url' => 'https://pinterest.com/pin/create/button/?url=',
        ),
        'whatsapp' => array(
            'name' => 'WhatsApp',
            'icon' => 'fab fa-whatsapp',
            'share_url' => 'https://wa.me/?text=',
        ),
    );
}

/**
 * Wyświetlanie linków social media w nagłówku
 */
function fotka_display_social_links($context = 'header') {
    $social_links = get_theme_mod('fotka_social_links', array());
    
    if (empty($social_links)) {
        return;
    }
    
    $platforms = fotka_get_available_social_platforms();
    
    foreach ($social_links as $link) {
        if (empty($link['platform']) || empty($link['url'])) {
            continue;
        }
        
        $platform = $link['platform'];
        
        if (!isset($platforms[$platform])) {
            continue;
        }
        
        $icon = $platforms[$platform]['icon'];
        $name = $platforms[$platform]['name'];
        $url = esc_url($link['url']);
        
        printf(
            '<a href="%s" class="social-link social-%s" target="_blank" rel="noopener noreferrer" aria-label="%s"><i class="%s"></i></a>',
            $url,
            esc_attr($platform),
            esc_attr($name),
            esc_attr($icon)
        );
    }
}

/**
 * Wyświetlanie przycisków udostępniania
 */
function fotka_display_social_share() {
    $share_platforms = get_theme_mod('fotka_share_platforms', array('facebook', 'twitter', 'linkedin'));
    
    if (empty($share_platforms)) {
        return;
    }
    
    $platforms = fotka_get_available_social_platforms();
    $post_url = urlencode(get_permalink());
    $post_title = urlencode(get_the_title());
    
    foreach ($share_platforms as $platform) {
        if (!isset($platforms[$platform])) {
            continue;
        }
        
        $platform_data = $platforms[$platform];
        
        if (empty($platform_data['share_url'])) {
            continue;
        }
        
        $share_url = $platform_data['share_url'] . $post_url;
        
        if ($platform === 'twitter') {
            $share_url .= '&text=' . $post_title;
        }
        
        printf(
            '<a href="%s" class="share-button share-%s" target="_blank" rel="noopener noreferrer" aria-label="Udostępnij na %s"><i class="%s"></i></a>',
            esc_url($share_url),
            esc_attr($platform),
            esc_attr($platform_data['name']),
            esc_attr($platform_data['icon'])
        );
    }
}
