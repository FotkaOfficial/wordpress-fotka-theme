<?php
/**
 * Fotka Theme Functions
 *
 * @package Fotka
 */

if (!defined('ABSPATH')) {
    exit;
}

// Definicje stałych
define('FOTKA_VERSION', '1.4.1');
define('FOTKA_THEME_DIR', get_template_directory());
define('FOTKA_THEME_URI', get_template_directory_uri());

/**
 * Setup motywu
 */
function fotka_theme_setup() {
    // Tłumaczenia
    load_theme_textdomain('fotka', FOTKA_THEME_DIR . '/languages');
    
    // Automatyczne linki RSS
    add_theme_support('automatic-feed-links');
    
    // Tytuł strony
    add_theme_support('title-tag');
    
    // Obrazy wyróżniające
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(800, 600, true);
    add_image_size('fotka-card', 400, 300, true);
    add_image_size('fotka-popular', 80, 80, true);
    
    // HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Kolory w edytorze
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary Blue', 'fotka'),
            'slug'  => 'primary-blue',
            'color' => '#00a8e1',
        ),
        array(
            'name'  => __('Dark Gray', 'fotka'),
            'slug'  => 'dark-gray',
            'color' => '#333333',
        ),
    ));
    
    // Menu
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'fotka'),
        'footer'  => __('Footer Menu', 'fotka'),
    ));
}
add_action('after_setup_theme', 'fotka_theme_setup');

/**
 * Rejestracja widgetów
 */
function fotka_widgets_init() {
    // Sidebar
    register_sidebar(array(
        'name'          => __('Sidebar', 'fotka'),
        'id'            => 'sidebar-1',
        'description'   => __('Główny sidebar pojawiający się po prawej stronie', 'fotka'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Footer widgety (3 kolumny)
    for ($i = 1; $i <= 3; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer Widget Area %d', 'fotka'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Footer widget area %d', 'fotka'), $i),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'fotka_widgets_init');

/**
 * Ładowanie skryptów i stylów
 */
function fotka_scripts() {
    // Style
    wp_enqueue_style('fotka-main', FOTKA_THEME_URI . '/assets/css/main.css', array(), FOTKA_VERSION);
    
    // Font Awesome dla ikon
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Skrypty
    wp_enqueue_script('fotka-main', FOTKA_THEME_URI . '/assets/js/main.js', array('jquery'), FOTKA_VERSION, true);
    
    // Komentarze
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'fotka_scripts');

/**
 * Włączanie plików
 */
require_once FOTKA_THEME_DIR . '/inc/social-media.php';
require_once FOTKA_THEME_DIR . '/inc/template-functions.php';
require_once FOTKA_THEME_DIR . '/inc/customizer.php';
require_once FOTKA_THEME_DIR . '/inc/theme-updater.php';

// Widgety
require_once FOTKA_THEME_DIR . '/inc/widgets/class-categories-widget.php';
require_once FOTKA_THEME_DIR . '/inc/widgets/class-popular-posts-widget.php';
require_once FOTKA_THEME_DIR . '/inc/widgets/class-search-widget.php';

/**
 * Rejestracja widgetów
 */
function fotka_register_widgets() {
    register_widget('Fotka_Categories_Widget');
    register_widget('Fotka_Popular_Posts_Widget');
    register_widget('Fotka_Search_Widget');
}
add_action('widgets_init', 'fotka_register_widgets');

/**
 * Excerpt length
 */
function fotka_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'fotka_excerpt_length');

/**
 * Excerpt more
 */
function fotka_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'fotka_excerpt_more');

/**
 * Dodanie meta tagów i skryptów z customizera
 */
function fotka_custom_header_scripts() {
    $custom_scripts = get_theme_mod('fotka_header_scripts', '');
    if (!empty($custom_scripts)) {
        echo $custom_scripts . "\n";
    }
}
add_action('wp_head', 'fotka_custom_header_scripts', 100);

/**
 * Dodanie skryptów przed zamknięciem body
 */
function fotka_custom_footer_scripts() {
    $custom_scripts = get_theme_mod('fotka_footer_scripts', '');
    if (!empty($custom_scripts)) {
        echo $custom_scripts . "\n";
    }
}
add_action('wp_footer', 'fotka_custom_footer_scripts', 100);

/**
 * Zmiana placeholdera wyszukiwarki
 */
function fotka_search_form_placeholder($form) {
    $form = str_replace('placeholder="Szukaj&hellip;"', 'placeholder="Szukaj"', $form);
    $form = str_replace('placeholder="Search&hellip;"', 'placeholder="Szukaj"', $form);
    return $form;
}
add_filter('get_search_form', 'fotka_search_form_placeholder');

/**
 * Wymuszenie użycia searchform.php dla widgetu wyszukiwania
 */
function fotka_force_search_form($form) {
    // Pobierz zawartość naszego searchform.php
    ob_start();
    get_template_part('searchform');
    $custom_form = ob_get_clean();
    
    // Jeśli mamy własny formularz, użyj go
    if (!empty($custom_form)) {
        return $custom_form;
    }
    
    return $form;
}
add_filter('get_search_form', 'fotka_force_search_form', 20);

/**
 * Wsparcie dla ikon Font Awesome w menu i treści
 */
function fotka_allow_font_awesome_in_menu($allowed_tags) {
    // Pozwól na tagi <i> w menu
    $allowed_tags['i'] = array(
        'class' => array(),
        'aria-hidden' => array(),
    );
    return $allowed_tags;
}
add_filter('wp_kses_allowed_html', 'fotka_allow_font_awesome_in_menu', 10, 1);

/**
 * Pozwól na ikony w tytułach menu
 */
function fotka_nav_menu_css_class($classes, $item) {
    if (strpos($item->title, '<i') !== false) {
        $classes[] = 'menu-item-has-icon';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'fotka_nav_menu_css_class', 10, 2);
