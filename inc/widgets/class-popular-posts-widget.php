<?php
/**
 * Popular Posts Widget
 *
 * @package Fotka
 */

class Fotka_Popular_Posts_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'fotka_popular_posts',
            __('Fotka: Popularne Posty', 'fotka'),
            array(
                'description' => __('Wyświetla najczęściej czytane posty', 'fotka'),
                'classname'   => 'fotka-popular-posts-widget',
            )
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Top 5 najczęściej czytanych', 'fotka');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        $show_thumbnail = !empty($instance['show_thumbnail']) ? $instance['show_thumbnail'] : 1;
        $show_date = !empty($instance['show_date']) ? $instance['show_date'] : 1;
        
        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        
        $popular_posts = fotka_get_popular_posts($number);
        
        if ($popular_posts->have_posts()) {
            echo '<ul class="popular-posts-list">';
            
            while ($popular_posts->have_posts()) {
                $popular_posts->the_post();
                ?>
                <li class="popular-post-item">
                    <?php if ($show_thumbnail && has_post_thumbnail()) : ?>
                        <div class="popular-post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('fotka-popular'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="popular-post-content">
                        <h4 class="popular-post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <?php if ($show_date) : ?>
                            <span class="popular-post-date"><?php echo get_the_date(); ?></span>
                        <?php endif; ?>
                    </div>
                </li>
                <?php
            }
            
            echo '</ul>';
            wp_reset_postdata();
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Top 5 najczęściej czytanych', 'fotka');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        $show_thumbnail = !empty($instance['show_thumbnail']) ? $instance['show_thumbnail'] : 1;
        $show_date = !empty($instance['show_date']) ? $instance['show_date'] : 1;
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
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>">
                <?php _e('Liczba postów:', 'fotka'); ?>
            </label>
            <input class="tiny-text" 
                   id="<?php echo esc_attr($this->get_field_id('number')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('number')); ?>" 
                   type="number" 
                   step="1" 
                   min="1" 
                   value="<?php echo esc_attr($number); ?>" 
                   size="3">
        </p>
        
        <p>
            <input class="checkbox" 
                   type="checkbox" 
                   <?php checked($show_thumbnail, 1); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_thumbnail')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_thumbnail')); ?>" 
                   value="1">
            <label for="<?php echo esc_attr($this->get_field_id('show_thumbnail')); ?>">
                <?php _e('Pokaż miniaturki', 'fotka'); ?>
            </label>
        </p>
        
        <p>
            <input class="checkbox" 
                   type="checkbox" 
                   <?php checked($show_date, 1); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" 
                   value="1">
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>">
                <?php _e('Pokaż datę', 'fotka'); ?>
            </label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        $instance['show_thumbnail'] = isset($new_instance['show_thumbnail']) ? 1 : 0;
        $instance['show_date'] = isset($new_instance['show_date']) ? 1 : 0;
        return $instance;
    }
}
