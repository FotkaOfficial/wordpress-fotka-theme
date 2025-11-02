<?php
/**
 * Search Form Template
 *
 * @package Fotka
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="search-input-wrapper">
        <input type="search" 
               class="search-field" 
               placeholder="<?php _e('Szukaj', 'fotka'); ?>" 
               value="<?php echo get_search_query(); ?>" 
               name="s" 
               aria-label="<?php _e('Szukaj', 'fotka'); ?>" />
        <button type="submit" class="search-submit" aria-label="<?php _e('Szukaj', 'fotka'); ?>">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>
