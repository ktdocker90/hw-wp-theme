<?php
/**
 * The template for displaying Post Format pages
 */
hw_get_header(); ?>
<div class="container-fluid">

<?php do_action('hw_before_main_content') ?>

<div class="row">
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-left'); ?>
	</div>

	<div id="content" class="site-content col-sm-6" role="main">
		<div class="panel panel-default"><div class="panel-body">
		<?php if ( have_posts() ) : ?>

		<header class="archive-header">
			<h1 class="archive-title">
				<?php
					if ( is_tax( 'post_format', 'post-format-aside' ) ) :
						_e( 'Asides', 'my-theme' );

					elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
						_e( 'Images', 'my-theme' );

					elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
						_e( 'Videos', 'my-theme' );

					elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
						_e( 'Audio', 'my-theme' );

					elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
						_e( 'Quotes', 'my-theme' );

					elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
						_e( 'Links', 'my-theme' );

					elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
						_e( 'Galleries', 'my-theme' );

					else :
						_e( 'Archives', 'my-theme' );

					endif;
				?>
			</h1>
		</header><!-- .archive-header -->

		<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;
				// Previous/next page navigation.
				hw_content_nav( 'nav-below' );

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
		?>
		</div></div>
	</div><!-- #content -->
	<div class="col-sm-3">
		<?php hw_dynamic_sidebar('sidebar-right');?>
	</div>
	
</div>
<?php  do_action('hw_after_main_content');?>
</div>

<?php
//get_sidebar( 'content' );
//get_sidebar();

hw_get_footer();
