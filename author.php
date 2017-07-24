<?php
/**
 * The template for displaying Author archive pages
 */
hw_get_header(); ?>
<div class="container-fluid">
<?php do_action('hw_before_main_content'); ?>

<div class="row">
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-left'); ?>
	</div>

	<div id="content" class="site-content col-sm-9" role="main">
		<div class="panel panel-default"><div class="panel-body">

		<?php if ( have_posts() ) : ?>

		<header class="archive-header">
			<h1 class="archive-title">
				<?php the_post();printf( __( 'All posts by %s', 'my-theme' ), get_the_author() );?>
			</h1>
			<?php if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
			<?php endif; ?>
		</header>

		<?php
				
				rewind_posts();

				// Start the Loop.
				while ( have_posts() ) : the_post();

					get_template_part( 'content', get_post_format() );

				endwhile;
				// Previous/next page navigation.
				hw_content_nav( 'nav-below' );

			else :
				
				get_template_part( 'content', 'none' );

			endif;
		?>
		
		</div></div>
	</div><!-- #content -->
	
</div>
<?php  do_action('hw_after_main_content');?>
</div>
<?php
//get_sidebar( 'content' );

hw_get_footer();
