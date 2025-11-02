<?php
/**
 * Categories Widget
 *
 * @package Fotka
 */

class Fotka_Categories_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'fotka_categories',
            __('Fotka: Lista Kategorii', 'fotka'),
            array(
                'description' => __('Wyświetla listę kategorii z licznikami', 'fotka'),
                'classname'   => 'fotka-categories-widget',
            )
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Kategorie', 'fotka');
        $hide_title = !empty($instance['hide_title']) ? $instance['hide_title'] : 0;
        $taxonomy = !empty($instance['taxonomy']) ? $instance['taxonomy'] : 'category';
        $show_count = !empty($instance['show_count']) ? $instance['show_count'] : 1;
        
        echo $args['before_widget'];
        
        if (!$hide_title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        $terms = get_terms(array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => true,
        ));
        
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<ul class="fotka-categories-list">';
            foreach ($terms as $term) {
                $count_html = '';
                if ($show_count) {
                    $count_html = ' <span class="category-count">' . $term->count . '</span>';
                }
                
                printf(
                    '<li><a href="%s">%s%s</a></li>',
                    esc_url(get_term_link($term)),
                    esc_html($term->name),
                    $count_html
                );
            }
            echo '</ul>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Kategorie', 'fotka');
        $hide_title = !empty($instance['hide_title']) ? $instance['hide_title'] : 0;
        $taxonomy = !empty($instance['taxonomy']) ? $instance['taxonomy'] : 'category';
        $show_count = !empty($instance['show_count']) ? $instance['show_count'] : 1;
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
        
        <p>
            <input class="checkbox" 
                   type="checkbox" 
                   <?php checked($hide_title, 1); ?> 
                   id="<?php echo esc_attr($this->get_field_id('hide_title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('hide_title')); ?>" 
                   value="1">
            <label for="<?php echo esc_attr($this->get_field_id('hide_title')); ?>">
                <?php _e('Ukryj tytuł', 'fotka'); ?>
            </label>
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>">
                <?php _e('Typ taksonomii:', 'fotka'); ?>
            </label>
            <select class="widefat" 
                    id="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>" 
                    name="<?php echo esc_attr($this->get_field_name('taxonomy')); ?>">
                <option value="category" <?php selected($taxonomy, 'category'); ?>>
                    <?php _e('Kategorie', 'fotka'); ?>
                </option>
                <option value="post_tag" <?php selected($taxonomy, 'post_tag'); ?>>
                    <?php _e('Tagi', 'fotka'); ?>
                </option>
            </select>
        </p>
        
        <p>
            <input class="checkbox" 
                   type="checkbox" 
                   <?php checked($show_count, 1); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_count')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_count')); ?>" 
                   value="1">
            <label for="<?php echo esc_attr($this->get_field_id('show_count')); ?>">
                <?php _e('Pokaż licznik', 'fotka'); ?>
            </label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['hide_title'] = isset($new_instance['hide_title']) ? 1 : 0;
        $instance['taxonomy'] = (!empty($new_instance['taxonomy'])) ? $new_instance['taxonomy'] : 'category';
        $instance['show_count'] = isset($new_instance['show_count']) ? 1 : 0;
        return $instance;
    }
}
