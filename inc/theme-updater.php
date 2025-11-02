<?php
/**
 * Theme Updater from GitHub
 *
 * @package Fotka
 */

if (!defined('ABSPATH')) {
    exit;
}

class Fotka_Theme_Updater {
    
    private $theme_slug;
    private $theme_version;
    private $github_username;
    private $github_repo;
    private $github_token; // Opcjonalny, dla prywatnych repozytoriów
    
    public function __construct() {
        $theme_data = wp_get_theme();
        
        $this->theme_slug = get_template();
        $this->theme_version = $theme_data->get('Version');
        
        // HARDCODED GITHUB CONFIGURATION
        // Zmień te wartości na swoje dane GitHub:
        $this->github_username = ''; // Wpisz swoją nazwę użytkownika GitHub
        $this->github_repo = '';     // Wpisz nazwę repozytorium (np. fotka-theme)
        $this->github_token = '';    // Opcjonalny - tylko dla prywatnych repozytoriów
        
        // Tylko jeśli GitHub jest skonfigurowany
        if (!empty($this->github_username) && !empty($this->github_repo)) {
            add_filter('pre_set_site_transient_update_themes', array($this, 'check_for_update'));
            add_filter('upgrader_source_selection', array($this, 'fix_theme_folder_name'), 10, 4);
        }
    }
    
    /**
     * Sprawdź czy jest dostępna aktualizacja
     */
    public function check_for_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }
        
        // Pobierz info o najnowszej wersji z GitHub
        $remote_version = $this->get_remote_version();
        
        if (!$remote_version) {
            return $transient;
        }
        
        // Porównaj wersje
        if (version_compare($this->theme_version, $remote_version['version'], '<')) {
            $transient->response[$this->theme_slug] = array(
                'theme'       => $this->theme_slug,
                'new_version' => $remote_version['version'],
                'url'         => $remote_version['html_url'],
                'package'     => $remote_version['download_url'],
            );
        }
        
        return $transient;
    }
    
    /**
     * Pobierz informacje o najnowszej wersji z GitHub
     */
    private function get_remote_version() {
        // Cache na 12 godzin
        $cache_key = 'fotka_github_version_' . md5($this->github_username . $this->github_repo);
        $cached = get_transient($cache_key);
        
        if ($cached !== false) {
            return $cached;
        }
        
        $api_url = sprintf(
            'https://api.github.com/repos/%s/%s/releases/latest',
            $this->github_username,
            $this->github_repo
        );
        
        $args = array(
            'headers' => array(
                'Accept' => 'application/vnd.github.v3+json',
            ),
        );
        
        // Dodaj token jeśli jest ustawiony (dla prywatnych repo)
        if (!empty($this->github_token)) {
            $args['headers']['Authorization'] = 'token ' . $this->github_token;
        }
        
        $response = wp_remote_get($api_url, $args);
        
        if (is_wp_error($response)) {
            return false;
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);
        
        if (empty($data->tag_name)) {
            return false;
        }
        
        // Tag name powinien być w formacie v1.0.0 lub 1.0.0
        $version = ltrim($data->tag_name, 'v');
        
        $result = array(
            'version'      => $version,
            'download_url' => $data->zipball_url,
            'html_url'     => $data->html_url,
            'description'  => !empty($data->body) ? $data->body : '',
        );
        
        // Cache na 12 godzin
        set_transient($cache_key, $result, 12 * HOUR_IN_SECONDS);
        
        return $result;
    }
    
    /**
     * Napraw nazwę folderu po pobraniu z GitHuba
     * GitHub nazywa foldery jako username-repo-hash, musimy zmienić na nazwę motywu
     */
    public function fix_theme_folder_name($source, $remote_source, $upgrader, $hook_extra) {
        global $wp_filesystem;
        
        // Tylko dla naszego motywu
        if (!isset($hook_extra['theme']) || $hook_extra['theme'] !== $this->theme_slug) {
            return $source;
        }
        
        $corrected_source = trailingslashit($remote_source) . $this->theme_slug . '/';
        
        if ($wp_filesystem->move($source, $corrected_source, true)) {
            return $corrected_source;
        }
        
        return $source;
    }
    
    /**
     * Wyczyść cache wersji
     */
    public function clear_version_cache() {
        $cache_key = 'fotka_github_version_' . md5($this->github_username . $this->github_repo);
        delete_transient($cache_key);
    }
}

// Inicjalizuj updater
new Fotka_Theme_Updater();
