<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<?php
/**
 * The template for displaying 404 pages (not found)
 */
hw_get_header(); ?>
<div class="container-fluid">
	<?php do_action('hw_before_main_content') ?>
<div class="row">

	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-left'); ?>
	</div>

	<div id="primary" class="content-area col-sm-6" role="main">
		<div class="panel panel-default"><div class="panel-body">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'my-theme' ); ?></h1>
				</header>

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'my-theme' ); ?></p>

					<?php get_search_form(); ?>
				</div>
			</section>
		<?php get_sidebar( 'content-bottom' ); ?>
		</div></div>
	</div><!-- .content-area -->
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-right');?>
	</div>
	
</div>
<?php do_action('hw_after_main_content') ?>
</div>
<?php //get_sidebar(); ?>

<?php hw_get_footer(); ?>
