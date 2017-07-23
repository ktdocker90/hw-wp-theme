<?php
return array(
	'content_classes'=> [
		'home'=> [
			'body_class' => 'home-css2',
			'post_class'=> 'post-class1',
			'remove_default'=> 1
		],
		'single'=> [
			'body_class'=> 'single-page',
			'post_class'=> 'single-page-post'
		],
		'taxonomy'=> [
			'body_class'=> 'tax1',
			'post_class'=> '',
		]
	],
	//'template_loop_product_title'=> '<h2 class="woocommerce-loop-product__title">%s</h2>',
	//'template_loop_category_title'=> '<h2 class="woocommerce-loop-category__title">%s</h2>',	
	'taxonomy_archive_description'=> '<div class="term-description">%s</div>',
	'product_archive_description'=> '<div class="page-description">%s</div>',
	'widget_shopping_cart_button_view_cart'=> '<a href="%s" class="button wc-forward">%s</a>',
	'widget_shopping_cart_proceed_to_checkout'=> '<a href="%s" class="button checkout wc-forward">%s</a>',
	'subcategory_thumbnail'=> '<img src="%s" alt="%s" width="%s" height="%s" srcset="%s" sizes="%s" />',
	//'single_variation'=> '<div class="woocommerce-variation single_variation"></div>',
	//'sale_flash'=> '<span class="onsale">%s</span>',
	
	'breadcrumb_defaults'=> array(
		'delimiter'   => '&nbsp;&#47;&nbsp;',
		'wrap_before' => '<nav class="woocommerce-breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	),
	'breadrumb_home_url'=> 'http://vinacart.net',
	'loop_shop_columns'=> array(
		'default'=> '4',
		'is_product_category'=> '4',
		'is_product'=> '2',
		'is_checkout'=> '4'
	),
	'content_before_cart_table'=> 'woo_before_cart_table',
	'filter_product_categories_widget_args'=> 'filter_product_categories_widget_args',
	//accept array or function
	'filter_product_tabs'=> function($tabs) {
		//unset( $tabs['description'] );
		return $tabs;
	},
	'filter_page_title'=> null,
	//'filter_default_catalog_orderby'=> 'date',
	
	'minimum_order_amount_error'=> 'You must have an order with a minimum of %s to place your order.',
	//'action_thankyou'=> 'woo_email_order_coupons',
	/*'filter_catalog_orderby'=> 'func',
	'filter_product_add_to_cart_url'=> 'func',
	'filter_get_price_html'=> 'func'
	'filter_get_availability_class'=> 'func',
	'filter_get_availability'=> 'func',
	'filter_checkout_fields'=> '',
	'filter_billing_fields'=> '',
	'filter_shipping_fields'=> '',
	'filter_default_address_fields'=> '',
	'content_after_order_notes'=> '',*/
	//'filter_upsell_display_args'=> '',
	//'filter_output_related_products_args'=> '',
	'filter_add_to_cart_fragments'=> 'filter_add_to_cart_fragments',
	''=> '',
	''=> '',
);