<?php
//global $more;$more=false;	//class="row"
?>
<div  id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
	
	<article class="col-xs-12">
		<h2><?php 
		if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			endif;
		?>
		</h2>
		
		<?php if ( /*is_search() || is_home() || is_archive()*/!is_single() ) : ?>
		<div class="row">
			<div class="col-md-3">
		<?php the_post_thumbnail('thumbnail'); ?>
			</div>
			<div class="col-md-9">

		<?php endif; ?>

		<?php if ( !is_single() ) : ?>
		<p><?php 
		echo hw_the_excerpt();
		//echo wp_trim_excerpt();
		//echo wp_trim_words(get_the_excerpt());// ?></p>
		<?php else : ?>
		<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'my-theme' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'my-theme' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			?>
		</div>
		<?php endif; ?>
		


		<!-- <p><button class="btn btn-default">Read More</button></p> -->
		<p class="pull-right">
		<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) /*&& hw_categorized_blog()*/ ) : ?>
		<span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'my-theme' ) ); ?></span>
		<?php
			endif;	
		?>
		<?php the_tags( '<div class="entry-meta"><span class="tag-links">', ',', '</span></div>' ); ?>
		</p>
		<p class="pull-right">
		<?php 
		if ( 'post' == get_post_type() )
				hw_posted_on();
		?>
		</p>
		<ul class="list-inline">
			<li><a href="#">Today</a></li>
			<li>
			<?php
				

				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'my-theme' ), __( '1 Comment', 'my-theme' ), __( '% Comments', 'my-theme' ) ); ?></span>
			<?php
				endif;

				
			?>
			</li>
			<li><?php edit_post_link( __( 'Edit', 'my-theme' ), '<span class="edit-link">', '</span>' ); ?></li>
		</ul>
		<?php if ( !is_single() ) : ?>
			</div>
		</div>
		<?php  endif ?>
	</article>
</div>
<hr/>