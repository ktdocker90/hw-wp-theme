<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
//constants
if(!defined('TEMPLATE_URL')) define('TEMPLATE_URL', get_bloginfo('template_url')); //echo TEMPLATE_URL,get_template_directory_uri()

if(!defined('TEMPLATE_PATH')) define('TEMPLATE_PATH', get_template_directory());

/**
 * Set up the content width value based on the theme's design.
 *
 * @see hw_content_width()
 *
 */
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}


/**
 * only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}



/**
 * Sets up theme defaults and registers the various WordPress features that
 * hoangweb supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 */
if(!function_exists('hw_theme_setup')):
function hw_theme_setup() {
	//Make available for translation.
	load_theme_textdomain( 'hw-theme' );

	// This theme styles the visual editor to resemble the theme style.
	//add_editor_style( array( 'assets/css/editor-style.css', hw_font_url(), 'assets/genericons/genericons.css' ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 672, 372, true );

	add_image_size( 'hw-full-width', 1038, 576, true );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	//set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

	// This theme uses wp_nav_menu() in two locations.
	/*register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'hw' ),
		'secondary' => __( 'Secondary menu in left sidebar', 'hw' ),
	) );*/
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	/*add_theme_support( 'custom-background', apply_filters( 'hw_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );*/

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'hw_get_featured_posts',
		'max_posts' => 6,
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

}
add_action( 'after_setup_theme', 'hw_theme_setup' );
endif;

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hw_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hw_content_width', 840 );
}
add_action( 'after_setup_theme', 'hw_content_width', 0 );


/**
 * Getter function for Featured Content Plugin.
 * @return array An array of WP_Post objects.
 */
function hw_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Twenty Fourteen.
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'hw_get_featured_posts', array() );
}


/**
 * A helper conditional function that returns a boolean value.
 *
 * @return bool Whether there are featured posts.
 */
function hw_has_featured_posts() {
	return ! is_paged() && (bool) hw_get_featured_posts();
}

/**
 * Register widget areas.
 */
function hw_widgets_init() {
	/*register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'hw-theme' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'hw-theme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'hw-theme' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Additional sidebar that appears on the right.', 'hw-theme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'hw-theme' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'hw-theme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	*/
}
add_action( 'widgets_init', 'hw_widgets_init' );

/**
 * Register Lato Google font
 *
 * @return string
 */
function hw_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'hw-theme' ) ) {
		$query_args = array(
			'family' => urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $font_url;
}

function hw_content_nav() {
	if(file_exists('template-parts/pagination.php')) :
		include ('template-parts/pagination.php');
	
	elseif(function_exists('wp_pagenavi')):
	    wp_pagenavi(/*array( 'type' => 'multipart' )*/);  
	else :
	// Previous/next page navigation.
	the_posts_pagination( array(
		'prev_text'          => __( 'Previous page', 'twentysixteen' ),
		'next_text'          => __( 'Next page', 'twentysixteen' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
	) );
	
	endif;
}

if ( ! function_exists( 'hw_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Twenty Fourteen 1.0
 */
function hw_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Twenty Fourteen attachment size.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'my_theme_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $idx => $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = $attachment_ids[ ( $idx + 1 ) % count( $attachment_ids ) ];
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( reset( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function my_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'my_customize_register' );



/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since hoangweb 1.0
 */
function my_customize_preview_js() {
    wp_enqueue_script( 'hw-theme-customizer', TEMPLATE_URL . '/assets/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'my_customize_preview_js' );


/**
 * Enqueues scripts and styles for front-end.
 *
 */
function hw_scripts_styles() {

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'hw-theme' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'hw-theme' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		//wp_enqueue_style( 'hw-theme-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'hw-theme-style', get_stylesheet_uri() );

	/*
	 * Loads the Internet Explorer specific stylesheet.
	 */
	//wp_enqueue_style( 'hw-theme-ie', TEMPLATE_URL . '/assets/css/ie.css', array( 'hw-theme-style' ), '20121010' );
	//$wp_styles->add_data( 'hw-theme-ie', 'conditional', 'lt IE 9' );
	
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'hw-theme-ie', get_template_directory_uri() . '/assets/css/ie.css', array( 'hw-theme-style' ), '20131205' );
	wp_style_add_data( 'hw-theme-ie', 'conditional', 'lt IE 9' );


	// Add Lato font, used in the main stylesheet.
	wp_enqueue_style( 'hw-theme-lato', hw_font_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	//wp_enqueue_style( 'genericons', get_template_directory_uri() . '/assets/genericons/genericons.css', array(), '3.0.3' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/*if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'hw-theme-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		wp_enqueue_script( 'hw-theme-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
		wp_localize_script( 'hw-theme-slider', 'featuredSliderDefaults', array(
			'prevText' => __( 'Previous', 'hw-theme' ),
			'nextText' => __( 'Next', 'hw-theme' )
		) );
	}
*/
	wp_enqueue_script( 'hw-theme-script', get_template_directory_uri() . '/asset/custom.js', array( 'jquery' ), '20150315', true );
}
add_action( 'wp_enqueue_scripts', 'hw_scripts_styles' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 */
function hw_admin_fonts() {
	wp_enqueue_style( 'hw-theme-lato', hw_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'hw_admin_fonts' );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Fourteen 1.9
 *
 * @param array   $urls          URLs to print for resource hints.
 * @param string  $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function hw_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'hw-theme-lato', 'queue' ) && 'preconnect' === $relation_type ) {
		if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		} else {
			$urls[] = 'https://fonts.gstatic.com';
		}
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'hw_resource_hints', 10, 2 );


/**
 * Extend the default WordPress body classes.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function hw_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} elseif ( ! in_array( $GLOBALS['pagenow'], array( 'wp-activate.php', 'wp-signup.php' ) ) ) {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	/*if ( ( ! is_active_sidebar( 'sidebar-2' ) )
		|| is_page_template( 'page-templates/full-width.php' )
		|| is_page_template( 'page-templates/contributors.php' )
		|| is_attachment() ) {
		$classes[] = 'full-width';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}
*/
	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	/*if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}*/

	return $classes;
}
//add_filter( 'body_class', 'hw_body_classes' );

/**
 * Extend the default WordPress post classes.
 */
function hw_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
//add_filter( 'post_class', 'hw_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 */
function hw_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'hw-theme' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'hw_wp_title', 10, 2 );


/**
 * Filter TinyMCE CSS path to include Google Fonts.
 *
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses hw_font_url() To get the Google Font stylesheet URL.
 *
 * @since  1.2
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string Filtered CSS path.
 */

function hw_mce_css( $mce_css ) {
	$font_url = hw_font_url();

	if ( empty( $font_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
//add_filter( 'mce_css', 'hw_mce_css' );

/**
 * @hook init
 */
function hw_init() {
    if (!is_admin() && $GLOBALS['pagenow'] !== 'wp-login.php') {
        //remove default jquery used in wordpress
        wp_deregister_script('jquery');
        wp_register_script('jquery', TEMPLATE_URL.'/asset/jquery-1.11.1.min.js', false); 
        //wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', false, '1.3.2'); 
        //wp_enqueue_script('jquery');
    }
    //set_post_thumbnail(89,109);
}
add_action('init', 'hw_init');


//modify script/style defer

/**
 * Deregister style file
 */
function hw_deregister_styles() {
	if(is_admin()) return;
    wp_deregister_style( 'yk-style' );
    if(!is_home()) {
		wp_deregister_style( '' );
	}
    wp_deregister_style( 'wp-pagenavi' );
    if(!is_single()) {
		wp_deregister_style( '' );
	}
    wp_deregister_style( 'yarppRelatedCss' );
    
   # Remove Custom Background
    remove_theme_support( 'custom-background');
}

add_action( 'wp_print_styles', 'hw_deregister_styles', 100 );
add_action( 'wp_enqueue_scripts', 'hw_deregister_styles', 100 );


/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function hw_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
//add_action( 'wp_head', 'hw_javascript_detection', 0 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function hw_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
//add_filter( 'wp_calculate_image_sizes', 'hw_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function hw_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
//add_filter( 'wp_get_attachment_image_attributes', 'hw_post_thumbnail_sizes_attr', 10 , 3 );


//for testing
/*add_filter('template_include', 'hw_load_template');
function hw_load_template($file) {
    return $file;
}*/

// Implement Custom Header features.
require get_template_directory() . '/inc/custom-header.php';

// Add Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
/*if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}*/

/**
 * Add an `is_customize_preview` function if it is missing.
 *
 * Enables installing Twenty Fourteen in WordPress versions before 4.0.0 when the
 * `is_customize_preview` function was introduced.
 */
if ( ! function_exists( 'is_customize_preview' ) ) :
function is_customize_preview() {
	global $wp_customize;

	return ( $wp_customize instanceof WP_Customize_Manager ) && $wp_customize->is_preview();
}
endif;
/*
session_start();
if(!is_admin()){
_print($_SESSION['tt1']);
}
*/
/*
add_filter('wp_get_attachment_image_attributes', 'hw_wp_get_attachment_image_attributes',10,3);
function hw_wp_get_attachment_image_attributes($attr, $attachment, $size) {
	$attr['class'] = 'img1';
	return $attr;
}

//custom fee to cart
function woo_before_cart_table() {
	global $woocommerce; 
	if ( is_cart() ) { 
		$woocommerce->cart->add_fee( __('Custom', 'woocommerce'), 5 ); 
	};
}
function filter_product_categories_widget_args($cat_args) {
	 $cat_args['exclude'] = array('16');
    
     return $cat_args;
}
function filter_page_title($page_title) {
	if( 'Shop' == $page_title) {
          return "My new title";
     }
}
function woo_email_order_coupons($order_id)
	{
	$order = new WC_Order($order_id);
	if ($order->get_used_coupons())
		{
		$to = 'youremail@yourcompany.com';
		$subject = 'New Order Completed';
		$headers = 'From: My Name ' . "\r\n";
		$message = 'A new order has been completed.\n';
		$message.= 'Order ID: ' . $order_id . '\n';
		$message.= 'Coupons used:\n';
		foreach($order->get_used_coupons() as $coupon)
			{
			$message.= $coupon . '\n';
			}

		@wp_mail($to, $subject, $message, $headers);
		}
	}
function filter_checkout_fields($fields) {
	$fields['account']['account_username']['required'] = true;
    $fields['account']['account_password']['required'] = true;
    $fields['account']['account_password-2']['required'] = true;

    return $fields;
}
function filter_billing_fields( $address_fields ) {
    $address_fields['billing_state']['required'] = false;
    return $address_fields;
}
function filter_shipping_fields( $address_fields ) {
    $address_fields['shipping_state']['required'] = false;
    return $address_fields;
}
// add fields to edit address page
function filter_default_address_fields( $fields ) {

     $new_fields = array(
                    'date_of_birth'     => array(
                    'label'             => __( '[Date of birth]', 'woocommerce' ),
                    'required'          => false,
                    'class'             => array( 'form-row' ),
               ),
          );
         
     $fields = array_merge( $fields, $new_fields );
    
    return $fields;
    
}
function content_after_order_notes( $checkout ) {

    echo '<div id="my_custom_checkout_field"><h2>' . __('My Field') . '</h2>';

    woocommerce_form_field( 'my_field_name', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Fill in this field'),
        'placeholder'   => __('Enter something'),
        ), $checkout->get_value( 'my_field_name' ));

    echo '</div>';

}

function filter_add_to_cart_fragments( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<a class="cart-customlocation " href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;	
}

*/
function hw_theme_comment($comment, $args, $depth) {
    /*if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }*/
    $add_below = 'div-comment';
    include (TEMPLATE_PATH. '/template-parts/comment.php');
}

require_once (__DIR__. '/inc/framework/loader.php');