<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>
		<div class="site-info">
                    <div class="site-footer__copyright">Copyright &copy; <?php echo date("Y"); ?>
			<?php $blog_info = get_bloginfo( 'name' ); ?>
			<?php if ( ! empty( $blog_info ) ) : ?>
				<a class="site-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>,
			<?php endif; ?>
                        All Rights Reserved.
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentynineteen' ) ); ?>" class="imprint">
				<?php
				/* translators: %s: WordPress. */
				printf( __( 'Proudly powered by %s.', 'twentynineteen' ), 'WordPress' );
				?>
			</a>
                    </div>
                    <div class="site-footer__location-and-phone">
                        <div class="site-footer__subheading">Location</div>
                        <div class="site-footer__location-text">842 Pine Highway Willamette Valley, Oregon</div>
                        <div class="site-footer__phone">503-712-0440</div>
                    </div>
                    <div class="site-footer__social">
                        <div class="site-footer__subheading">Social</div>
                        <div class="site-footer__social-inner-wrapper">
                        <div class="site-footer__social-logo facebook">
                            <a class="site-footer__social-link" href=""><i class="fab fa-facebook-f fa-2x social-icon"><span class="sr-only">Facebook</span></i></a>
                        </div>
                        <div class="site-footer__social-logo twitter">
                            <a class="site-footer__social-link" href=""><i class="fab fa-twitter fa-2x social-icon"><span class="sr-only">Twitter</span></i></a>
                        </div>
                        <div class="site-footer__social-logo pinterest">
                            <a class="site-footer__social-link" href=""><i class="fab fa-pinterest fa-2x social-icon"><span class="sr-only">Pinterest</span></i></a>
                        </div>
                        </div>
                    </div>
                    <div class="site-footer__hours">
                        <div class="site-footer__subheading">Hours</div>
                        <div class="">Tuesday - Friday: 10am - 5pm</div>
                        <div class="">Saturday: 9am - 6pm</div>
                    </div>
                    <?php
                    if ( function_exists( 'the_privacy_policy_link' ) ) {
                            the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
                    }
                    ?>
                    <?php if ( has_nav_menu( 'footer' ) ) : ?>
                            <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'twentynineteen' ); ?>">
                                    <?php
                                    wp_nav_menu(
                                            array(
                                                    'theme_location' => 'footer',
                                                    'menu_class'     => 'footer-menu',
                                                    'depth'          => 1,
                                            )
                                    );
                                    ?>
                            </nav><!-- .footer-navigation -->
                    <?php endif; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
