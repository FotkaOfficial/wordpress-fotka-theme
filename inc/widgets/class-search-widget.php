<?php
/**
 * Fotka Search Widget
 *
 * @package Fotka
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Widget wyszukiwarki z ikoną lupy wewnątrz inputa
 */
class Fotka_Search_Widget extends WP_Widget {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'fotka_search_widget',
            __('Fotka: Wyszukiwarka', 'fotka'),
            array(
                'description' => __('Formularz wyszukiwania z ikoną lupy wewnątrz inputa', 'fotka'),
                'classname'   => 'fotka-search-widget',
            )
        );
    }
    
    /**
     * Front-end display of widget
     */
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        // Użyj naszego customowego formularza
        get_search_form();
        
        echo $args['after_widget'];
    }
    
    /**
     * Back-end widget form
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Tytuł:', 'fotka'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p class="description">
            <?php _e('Widget wyszukiwarki z ikoną lupy wewnątrz inputa, bez zewnętrznych paddingów.', 'fotka'); ?>
        </p>
        <?php
    }
    
    /**
     * Sanitize widget form values
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}
