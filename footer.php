<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-blurb">
			<div class="container">
				<div class="row">
					<?php hw_dynamic_sidebar('footer') ?>
		<?php /*if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Primary Menu', 'my-theme' ); ?>">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'     => 'primary-menu',
					 ) );
				?>
			</nav><!-- .main-navigation -->
		<?php endif;*/ ?>

				</div>
			</div>
		</div>

		<div class="small-print">
        	<div class="container">
        	<?php
				
				do_action( 'hw_credits' );
			?>
        		<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'my-theme' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'my-theme' ), 'WordPress' ); ?></a>
        	</div>
        </div>
		
	</footer><!-- .site-footer -->
	
</div><!-- .site -->

<?php wp_footer(); ?>
<?PHP //echo hw_option('footer')?>
</body>
</html>
