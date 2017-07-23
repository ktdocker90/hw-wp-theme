<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<?php
/**
 * The template for displaying Search Results pages
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
        <?php if ( have_posts() ) : ?>

        <header class="page-header">
            <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'my-theme' ), get_search_query() ); ?></h1>
        </header><!-- .page-header -->

            <?php #hw_theme_get_main() ?>
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
                // Previous/next post navigation.
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
<?php do_action('hw_after_main_content') ?>
</div> 
<?php
//get_sidebar( 'content' );
hw_get_footer();






