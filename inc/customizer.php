<?php
/**
 * Theme Customizer
 *
 * @package Fotka
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Rejestracja ustawień w Customizerze
 */
function fotka_customize_register($wp_customize) {
    
    // Najpierw załaduj klasy kontrolek
    require_once get_template_directory() . '/inc/customizer-controls.php';
    
    // ===== PANEL GŁÓWNY FOTKA =====
    $wp_customize->add_panel('fotka_panel', array(
        'title'       => __('Ustawienia Motywu Fotka', 'fotka'),
        'description' => __('Wszystkie ustawienia motywu Fotka', 'fotka'),
        'priority'    => 10,
    ));
    
    // ===== SEKCJA: SOCIAL MEDIA - NAGŁÓWEK =====
    $wp_customize->add_section('fotka_header_social', array(
        'title'    => __('Social Media - Nagłówek', 'fotka'),
        'panel'    => 'fotka_panel',
        'priority' => 20,
    ));
    
    // Social Links Repeater
    $wp_customize->add_setting('fotka_social_links', array(
        'default'           => array(),
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh',
        'sanitize_callback' => 'fotka_sanitize_social_links',
    ));
    
    $wp_customize->add_control(new Fotka_Social_Links_Control(
        $wp_customize,
        'fotka_social_links',
        array(
            'label'       => __('Linki Social Media', 'fotka'),
            'description' => __('Dodaj linki do swoich profili w mediach społecznościowych', 'fotka'),
            'section'     => 'fotka_header_social',
            'priority'    => 10,
        )
    ));
    
    // ===== SEKCJA: UDOSTĘPNIANIE =====
    $wp_customize->add_section('fotka_sharing', array(
        'title'    => __('Udostępnianie Artykułów', 'fotka'),
        'panel'    => 'fotka_panel',
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('fotka_share_platforms', array(
        'default'           => array('facebook', 'twitter', 'linkedin'),
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh',
        'sanitize_callback' => 'fotka_sanitize_checkboxes',
    ));
    
    $wp_customize->add_control(new Fotka_Share_Platforms_Control(
        $wp_customize,
        'fotka_share_platforms',
        array(
            'label'       => __('Platformy udostępniania', 'fotka'),
            'description' => __('Wybierz platformy, na których można udostępniać artykuły', 'fotka'),
            'section'     => 'fotka_sharing',
            'priority'    => 10,
        )
    ));
    
    // ===== SEKCJA: STOPKA =====
    $wp_customize->add_section('fotka_footer', array(
        'title'    => __('Stopka', 'fotka'),
        'panel'    => 'fotka_panel',
        'priority' => 40,
    ));
    
    $wp_customize->add_setting('fotka_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('fotka_footer_text', array(
        'label'       => __('Tekst stopki', 'fotka'),
        'description' => __('Wprowadź tekst, który ma się wyświetlać w stopce (może zawierać HTML)', 'fotka'),
        'section'     => 'fotka_footer',
        'type'        => 'textarea',
    ));
    
    // Aplikacje mobilne - Android
    $wp_customize->add_setting('fotka_android_app_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('fotka_android_app_url', array(
        'label'       => __('Link do aplikacji Android', 'fotka'),
        'description' => __('URL do aplikacji w Google Play', 'fotka'),
        'section'     => 'fotka_footer',
        'type'        => 'url',
    ));
    
    // Aplikacje mobilne - iOS
    $wp_customize->add_setting('fotka_ios_app_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('fotka_ios_app_url', array(
        'label'       => __('Link do aplikacji iOS', 'fotka'),
        'description' => __('URL do aplikacji w App Store', 'fotka'),
        'section'     => 'fotka_footer',
        'type'        => 'url',
    ));
    
    // ===== SEKCJA: KODY ŚLEDZĄCE =====
    $wp_customize->add_section('fotka_tracking', array(
        'title'       => __('Kody śledzące i meta tagi', 'fotka'),
        'description' => __('Dodaj kody Google Analytics, Meta Pixel, tagi weryfikacyjne itp.', 'fotka'),
        'panel'       => 'fotka_panel',
        'priority'    => 50,
    ));
    
    // Skrypty w <head>
    $wp_customize->add_setting('fotka_header_scripts', array(
        'default'           => '',
        'sanitize_callback' => 'fotka_sanitize_scripts',
    ));
    
    $wp_customize->add_control('fotka_header_scripts', array(
        'label'       => __('Skrypty w sekcji <head>', 'fotka'),
        'description' => __('Wklej tutaj kody Analytics, Tag Manager, tagi weryfikacyjne itp. (będą dodane przed zamknięciem taga </head>)', 'fotka'),
        'section'     => 'fotka_tracking',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows' => 10,
            'placeholder' => '<!-- Google Analytics -->' . "\n" . '<script>' . "\n" . '  // Twój kod' . "\n" . '</script>',
        ),
    ));
    
    // Skrypty przed </body>
    $wp_customize->add_setting('fotka_footer_scripts', array(
        'default'           => '',
        'sanitize_callback' => 'fotka_sanitize_scripts',
    ));
    
    $wp_customize->add_control('fotka_footer_scripts', array(
        'label'       => __('Skrypty przed zamknięciem </body>', 'fotka'),
        'description' => __('Wklej tutaj kody, które powinny być załadowane na końcu strony', 'fotka'),
        'section'     => 'fotka_tracking',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows' => 10,
        ),
    ));
}
add_action('customize_register', 'fotka_customize_register');

/**
 * Sanitize Social Links
 */
function fotka_sanitize_social_links($input) {
    // Jeśli to string (JSON), dekoduj
    if (is_string($input)) {
        $input = json_decode($input, true);
    }
    
    if (!is_array($input)) {
        return array();
    }
    
    $sanitized = array();
    
    foreach ($input as $item) {
        if (is_array($item) && !empty($item['platform']) && !empty($item['url'])) {
            $sanitized[] = array(
                'platform' => sanitize_key($item['platform']),
                'url'      => esc_url_raw($item['url']),
            );
        }
    }
    
    return $sanitized;
}

/**
 * Sanitize Checkboxes
 */
function fotka_sanitize_checkboxes($input) {
    // Jeśli to string (JSON), dekoduj
    if (is_string($input)) {
        $input = json_decode($input, true);
    }
    
    if (!is_array($input)) {
        return array();
    }
    
    return array_map('sanitize_key', $input);
}

/**
 * Sanitize Scripts - bardziej liberalne, ale bezpieczne
 */
function fotka_sanitize_scripts($input) {
    // Dozwolone tagi dla skryptów
    $allowed_tags = array(
        'script' => array(
            'src'   => array(),
            'type'  => array(),
            'async' => array(),
            'defer' => array(),
        ),
        'meta' => array(
            'name'     => array(),
            'content'  => array(),
            'property' => array(),
        ),
        'link' => array(
            'rel'  => array(),
            'href' => array(),
        ),
        'noscript' => array(),
        'style' => array(
            'type' => array(),
        ),
    );
    
    return wp_kses($input, $allowed_tags);
}
