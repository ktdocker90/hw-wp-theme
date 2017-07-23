<?php
/**
 * The template for displaying Category pages.
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
 <?php
//if(isset($wp_taxonomies)) {
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    if($term) {
        #echo '<h2 class="pagetitle">'.$term->name.'</h2>';
    }
    // If you have a taxonomy description, let'er rip!
    if(function_exists('get_yoast_term_description') && get_yoast_term_description()) {
        echo wptexturize(get_yoast_term_description());
    }
    else{
        if ( term_description() ) : // Show an optional category description
            echo term_description();
        endif;
    }
//}
	?>
	

 <?php echo single_cat_title( '', false )?>

    <?php if ( have_posts() ) : ?>
    <div class="">
        <?php
        /* Start the Loop */
        while ( have_posts() ) : the_post();

            /* Include the post format-specific template for the content. If you want to
             * this in a child theme then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            get_template_part( 'content', 'feature' );

        endwhile;

        ?>
    </div>
    <?php hw_content_nav( 'nav-below' );?>

    <?php else : ?>
        <?php get_template_part( 'content', 'none' ); ?>
    <?php endif; ?>
        </div></div>
    </div>
    <div class="col-sm-3">
        <?php hw_dynamic_sidebar('sidebar-right');?>
    </div>
               

</div>
<?php  do_action('hw_after_main_content');?>
</div>

<?php hw_get_footer()?>