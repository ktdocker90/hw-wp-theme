<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 */

hw_get_header(); ?>
<div class="container-fluid">
<?php do_action('hw_before_main_content')?>

<div class="row">
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-left'); ?>
	</div>

	<div id="content" class="site-content col-sm-6" role="main">
		<div class="panel panel-default"><div class="panel-body">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				get_template_part( 'content', get_post_format() );

				// Previous/next post navigation.
				//hw_post_nav();
				hw_content_nav();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				//echo do_shortcode('[hwfb_comment]');
			endwhile;
		?>
		<?php if(function_exists('hwrp_display_related')) hwrp_display_related() ?>
		</div></div>
	</div><!-- #content -->
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-right');?>
	</div>
	
</div>
<?php do_action('hw_after_main_content') ?>
</div>
<?php
//get_sidebar( 'content' );
//get_sidebar();
hw_get_footer();

