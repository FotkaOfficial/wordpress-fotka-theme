<?php
/**
 * Custom Customizer Controls
 *
 * @package Fotka
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom Control - Social Links Repeater
 */
class Fotka_Social_Links_Control extends WP_Customize_Control {
    public $type = 'social_links_repeater';
    
    public function to_json() {
        parent::to_json();
        $this->json['value'] = $this->value();
        $this->json['link'] = $this->get_link();
        $this->json['id'] = $this->id;
    }
    
    public function enqueue() {
        wp_enqueue_script(
            'fotka-customizer-controls',
            get_template_directory_uri() . '/assets/js/customizer-controls.js',
            array('jquery', 'customize-controls'),
            FOTKA_VERSION,
            true
        );
        
        wp_enqueue_style(
            'fotka-customizer-controls',
            get_template_directory_uri() . '/assets/css/customizer-controls.css',
            array(),
            FOTKA_VERSION
        );
    }
    
    public function render_content() {
        $platforms = fotka_get_available_social_platforms();
        $value = $this->value();
        
        // Dekoduj JSON jeśli wartość to string
        if (is_string($value) && !empty($value)) {
            $value = json_decode($value, true);
        }
        
        if (!is_array($value)) {
            $value = array();
        }
        ?>
        <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <?php if (!empty($this->description)) : ?>
            <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php endif; ?>
        
        <div class="fotka-social-links-repeater">
            <div class="fotka-social-links-list" data-name="<?php echo esc_attr($this->id); ?>">
                <?php
                if (!empty($value)) {
                    foreach ($value as $index => $link) {
                        $this->render_social_link_item($index, $link, $platforms);
                    }
                }
                ?>
            </div>
            
            <button type="button" class="button fotka-add-social-link">
                <?php _e('+ Dodaj kolejny link', 'fotka'); ?>
            </button>
            
            <script type="text/template" id="tmpl-fotka-social-link-item">
                <?php $this->render_social_link_item('{{data.index}}', array(), $platforms, true); ?>
            </script>
            
            <?php 
            // Debug - sprawdź co jest w settings
            $setting_id = '';
            if (isset($this->settings['default'])) {
                $setting_id = $this->settings['default']->id;
            } elseif (!empty($this->setting)) {
                $setting_id = $this->setting->id;
            } else {
                $setting_id = $this->id;
            }
            ?>
            <input type="hidden" 
                   id="<?php echo esc_attr($this->id); ?>"
                   name="<?php echo esc_attr($this->id); ?>"
                   value="<?php echo esc_attr(wp_json_encode($value)); ?>" 
                   class="fotka-social-links-value" 
                   data-customize-setting-link="<?php echo esc_attr($setting_id); ?>" />
        </div>
        <?php
    }
    
    private function render_social_link_item($index, $link = array(), $platforms = array(), $is_template = false) {
        $platform = isset($link['platform']) ? $link['platform'] : '';
        $url = isset($link['url']) ? $link['url'] : '';
        
        if ($is_template) {
            $platform = '{{data.platform}}';
            $url = '{{data.url}}';
        }
        ?>
        <div class="fotka-social-link-item" data-index="<?php echo esc_attr($index); ?>">
            <div class="fotka-social-link-controls">
                <select class="fotka-social-platform">
                    <option value=""><?php _e('Wybierz platformę', 'fotka'); ?></option>
                    <?php foreach ($platforms as $key => $data) : ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($platform, $key); ?>>
                            <?php echo esc_html($data['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <input type="url" class="fotka-social-url" placeholder="https://" value="<?php echo esc_url($url); ?>">
                
                <button type="button" class="button fotka-remove-social-link">
                    <span class="dashicons dashicons-trash"></span>
                </button>
            </div>
        </div>
        <?php
    }
}

/**
 * Custom Control - Share Platforms
 */
class Fotka_Share_Platforms_Control extends WP_Customize_Control {
    public $type = 'share_platforms';
    
    public function to_json() {
        parent::to_json();
        $this->json['value'] = $this->value();
        $this->json['link'] = $this->get_link();
        $this->json['id'] = $this->id;
    }
    
    public function enqueue() {
        wp_enqueue_script(
            'fotka-customizer-controls',
            get_template_directory_uri() . '/assets/js/customizer-controls.js',
            array('jquery', 'customize-controls'),
            FOTKA_VERSION,
            true
        );
        
        wp_enqueue_style(
            'fotka-customizer-controls',
            get_template_directory_uri() . '/assets/css/customizer-controls.css',
            array(),
            FOTKA_VERSION
        );
    }
    
    public function render_content() {
        $platforms = fotka_get_available_social_platforms();
        $value = $this->value();
        
        // Dekoduj JSON jeśli wartość to string
        if (is_string($value) && !empty($value)) {
            $value = json_decode($value, true);
        }
        
        if (!is_array($value)) {
            $value = array();
        }
        ?>
        <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <?php if (!empty($this->description)) : ?>
            <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php endif; ?>
        
        <div class="fotka-share-platforms">
            <?php foreach ($platforms as $key => $data) : ?>
                <?php if (!empty($data['share_url'])) : ?>
                    <label>
                        <input type="checkbox" 
                               class="fotka-share-checkbox"
                               value="<?php echo esc_attr($key); ?>" 
                               <?php checked(in_array($key, $value)); ?>>
                        <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                        <?php echo esc_html($data['name']); ?>
                    </label>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <?php 
            // Debug - sprawdź co jest w settings
            $setting_id = '';
            if (isset($this->settings['default'])) {
                $setting_id = $this->settings['default']->id;
            } elseif (!empty($this->setting)) {
                $setting_id = $this->setting->id;
            } else {
                $setting_id = $this->id;
            }
            ?>
            <input type="hidden" 
                   id="<?php echo esc_attr($this->id); ?>"
                   name="<?php echo esc_attr($this->id); ?>"
                   value="<?php echo esc_attr(wp_json_encode($value)); ?>" 
                   class="fotka-share-platforms-value" 
                   data-customize-setting-link="<?php echo esc_attr($setting_id); ?>" />
        </div>
        <?php
    }
}
