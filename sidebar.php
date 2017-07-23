<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 */
?>
<div id="secondary">
	<?php
		/*$description = get_bloginfo( 'description', 'display' );
		if ( ! empty ( $description ) ) :
	?>
	<h2 class="site-description"><?php echo esc_html( $description ); ?></h2>
	<?php endif;*/ ?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php hw_dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
	<?php endif; ?>
</div>
