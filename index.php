<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<?php
/*//home sidebar
if(function_exists('hw_dynamic_sidebar')) hw_dynamic_sidebar('sidebar-home-1');
    else dynamic_sidebar('sidebar-home-1');
?>
<?php
//home sidebar
if(function_exists('hw_dynamic_sidebar')) hw_dynamic_sidebar('sidebar-home-2');
    else dynamic_sidebar('sidebar-home-2');
*/
?>
<?php
/**
 * The main template file
 */
hw_get_header(); ?>
<div class="container-fluid">
	<?php do_action('hw_before_main_content'); ?>
<div class="row">

	<!-- Left Column --><!-- //get_sidebar( /*'content'*/ ); -->
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
			//hw_theme_get_main();	//new way
		do_action ('hw_before_loop');
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

					get_template_part( 'content', get_post_format() );

				endwhile;
				// Previous/next post navigation.
				hw_content_nav();

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
		do_action ('hw_after_loop');
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
//get_sidebar();
hw_get_footer();
