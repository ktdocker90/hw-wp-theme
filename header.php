<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
//echo get_theme_mod('image_logo')

/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container-fluid">
            <!-- Logo and responsive toggle -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"> <img src="<?php echo get_theme_mod('image_logo')?>" class="logo"/> <?php bloginfo( 'name' ); ?></a>
            </div>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse " id="navbar">
            	<ul class="nav navbar-nav" style="margin-top:10px;width:80%">
            		<li>
            			<!-- Search -->
						<?php //_e( 'Search', 'my-theme' ); ?>
						
						<?php get_search_form(); ?>
            		</li>
            		<li></li>
            		<li style="float:right;">
            			<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
						  	<a class="cart-customlocation" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu dropdown-menu-right">
						    <li style="padding:10px" class="woocommerce widget_shopping_cart">
						    <?php 
						    //with no sidebar so use class
						    hw_widget_content('widget="WC_Widget_Cart" args="hide_if_empty=1"'); 
						    ?>
						    </li>
						    
						  </ul>
						</div>
            		</li>
            	</ul>
            	<div class="row" style="float:right;width: 80%">
                <div class="col-md-6">
				
				</div>
				<div class="col-md-6">
					

					

				</div>
				</div>
            </div>
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu' ) ); ?>

            

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	<?php /*if ( get_header_image() ) : ?>
	<div id="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
		</a>
	</div>
	<?php endif;*/ ?>


<?php echo do_shortcode('[hw_metaslider id=7]') ?>