<?php
//global $more;$more=false;	//class="row"
?>
<div  id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
	
	<article class="col-xs-12">
		<h1 class="entry-title">
			<?php if ( !is_single() ) :?><a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark"><?php endif ?>
		<?php the_title( '', '' ); ?>
			
			<?php if ( !is_single() ) :?></a><?php endif; ?>
		</h1>
		
		
		<?php if ( /*is_search() || is_home() || is_archive()*/!is_single() ) : ?>
		<div class="row">
			<div class="col-md-3">
		<img src="<?php the_post_thumbnail_url('thumbnail'); ?>"/>
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
				/*the_content( sprintf(
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'my-theme' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );*/

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
		
		<!-- #categories -->
		<?php
		$categories_list = get_the_category_list( __( ', ', 'twentythirteen' ) );
		if ( $categories_list ) { ?>
			<span class="categories-links"><?php echo $categories_list ?></span>
		<?php } ?>

		<!-- # tags -->
		<?php 		
		$tag_list = get_the_tag_list( '', __( ', ', 'twentythirteen' ) );
		if ( $tag_list ) {
		?>
	
		<div class="entry-meta"><span class="tag-links"><?php $tag_list; ?></span></div>
		<?php } ?>

		<!-- # post author -->
		<?php
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'hw-theme' ), get_the_author() ) ),
			get_the_author()
		);
		?>
		<!-- # comment -->
		<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'my-theme' ), __( '1 Comment', 'my-theme' ), __( '% Comments', 'my-theme' ) ); ?></span>
			<?php
				endif;
			?>
		<!-- date -->
		<?php
		printf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'hw-theme' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( '%2$s', get_post_format_string( get_post_format() ), get_the_date() ) )
	);?>

		</p>
		<p class="pull-right">
		<?php 
		/*if ( 'post' == get_post_type() )
				hw_posted_on();*/
		?>
		</p>
		<?php edit_post_link( __( 'Edit', 'my-theme' ), '<span class="edit-link">', '</span>' ); ?>
		
		<?php if ( !is_single() ) : ?>
			</div>
		</div>
		<?php  endif ?>
	</article>
</div>
<hr/>