<?php
/**
 * The sidebar template
 *
 * @package Fotka
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside class="sidebar-area" role="complementary">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>
