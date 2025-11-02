<?php
/**
 * The footer template
 *
 * @package Fotka
 */
?>

</div><!-- .site-container -->

<footer class="site-footer">
    <div class="footer-content">
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
            <div class="footer-widgets">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="footer-bottom">
            <?php
            $footer_text = get_theme_mod('fotka_footer_text', '');
            if (!empty($footer_text)) {
                echo wp_kses_post($footer_text);
            } else {
                printf(
                    esc_html__('© %1$s %2$s. Wszystkie prawa zastrzeżone.', 'fotka'),
                    date('Y'),
                    get_bloginfo('name')
                );
            }
            ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
