<?php
/**
 * @package  WordPress
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>

<?php
/**
 * The template for displaying archive pages
 */
hw_get_header(); ?>
<div class="container-fluid">
	<?php do_action('hw_before_main_content') ?>
	<div class="row">
<?php //hw_theme_get_main()?>
	
	
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-left'); ?>
	</div>

	<div id="primary" class="content-area col-sm-6">
		<div class="panel panel-default"><div class="panel-body">
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			/*the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'hw-theme' ),
				'next_text'          => __( 'Next page', 'hw-theme' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'hw-theme' ) . ' </span>',
			) );*/
			hw_content_nav( 'nav-below' );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		</div></div>
	</div><!-- .content-area -->
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-right');?>
	</div>
	
</div>
<?php  do_action('hw_after_main_content');?>
</div>
<?php //get_sidebar(); ?>
<?php hw_get_footer(); ?>
