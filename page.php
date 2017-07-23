<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
 ?>

<?php
hw_get_header(); ?>
<div class="container-fluid">

<?php #hw_theme_get_main() ?>
<?php do_action('hw_before_main_content'); ?>
<div class="row">
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-left'); ?>
	</div>

	<div id="main-content" class="main-content col-sm-6">
		<div class="panel panel-default"><div class="panel-body">
<?php
	if ( is_front_page() && hw_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
		<div id="content" class="site-content" role="main">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>

		</div><!-- #content -->
		</div></div>
	
	</div><!-- #main-content -->
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-right');?>
	</div>
</div>
<?php do_action('hw_after_main_content'); ?>
</div>

<?php
hw_get_footer();

