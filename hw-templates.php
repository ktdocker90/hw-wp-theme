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
		],
		'page'=> [
			'body_class'=> 'page1',
			'post_class'=> '',
		]
	],
	'woo_settings'=> [
		//general
		//Enable/Disable deferred email sending
		'defer_transactional_emails'=> false,
		//Notify admin when a new customer account is created
		'created_customer_admin_notify'=> true,

		//checkout
		//Minimum Order Amount
		'minimum_order_amount'=> '1',

		//PRODUCT
		//Hide price suffix when product is not taxable.
		'hide_price_suffix_with_not_taxable'=> true,
		'disable_all_sale_prices'=> false,	//Disable ALL sale prices
		'hide_subcategory_count'=> true,	//Hide sub-category product count
		'upsells_limit'=> '10',	//Upsells product limit
		'related_products_limit'=> '10',	//Related products limit
		'loop_shop_per_page'=> '20',	//Products displayed per page
		'hide_loop_read_more'=> false,	//Hide loop read more buttons for out of stock items
		
	],
	//'template_loop_product_title'=> '<h2 class="woocommerce-loop-product__title">%s</h2>',
	//'template_loop_category_title'=> '<h2 class="woocommerce-loop-category__title">%s</h2>',	
	'woo_taxonomy_archive_description'=> '<div class="term-description">%s</div>',
	'woo_product_archive_description'=> '<div class="page-description">%s</div>',
	
	//move to woocommerce/custom/
	//'widget_shopping_cart_button_view_cart'=> '<a href="%s" class="button wc-forward">%s</a>',
	//'widget_shopping_cart_proceed_to_checkout'=> '<a href="%s" class="button checkout wc-forward">%s</a>',
	
	'woo_subcategory_thumbnail'=> '<img src="%s" alt="%s" width="%s" height="%s" srcset="%s" sizes="%s" />',
	//'single_variation'=> '<div class="woocommerce-variation single_variation"></div>',
	//'sale_flash'=> '<span class="onsale">%s</span>',
	
	'woo_breadcrumb_defaults'=> array(
		'delimiter'   => '&nbsp;&#47;&nbsp;',
		'wrap_before' => '<nav class="woocommerce-breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	),
	'woo_breadrumb_home_url'=> 'http://vinacart.net',
	'yoast_breadcrumb'=> [
		'separator'=> '/'
	],
	'woo_loop_shop_columns'=> array(
		'default'=> '4',
		'is_product_category'=> '4',
		'is_product'=> '2',
		'is_checkout'=> '4'
	),
	'woo_content_before_cart_table'=> 'woo_before_cart_table',
	'woo_filter_product_categories_widget_args'=> 'filter_product_categories_widget_args',
	//accept array or function
	'woo_filter_product_tabs'=> function($tabs) {
		//unset( $tabs['description'] );
		return $tabs;
	},
	'woo_filter_page_title'=> null,
	//'filter_default_catalog_orderby'=> 'date',
	
	'woo_minimum_order_amount_error'=> 'You must have an order with a minimum of %s to place your order.',
	//'woo_action_thankyou'=> 'woo_email_order_coupons',
	/*'woo_filter_catalog_orderby'=> 'func',
	'woo_filter_product_add_to_cart_url'=> 'func',
	'woo_filter_get_price_html'=> 'func'
	'woo_filter_get_availability_class'=> 'func',
	'woo_filter_get_availability'=> 'func',
	'woo_filter_checkout_fields'=> '',
	'woo_filter_billing_fields'=> '',
	'woo_filter_shipping_fields'=> '',
	'woo_filter_default_address_fields'=> '',
	'woo_content_after_order_notes'=> '',*/
	//'woo_filter_upsell_display_args'=> '',
	//'woo_filter_output_related_products_args'=> '',
	'woo_filter_add_to_cart_fragments'=> 'filter_add_to_cart_fragments',
	'navmenu'=> [
		'primary'=> [
			'ex_separator'=> '|',
			'submenu_container_class'=> 'dropdown-menu menu-level-1',
			//'allow_tags_nav_menu'=> '',
			'anchor_attrs'=> '',
			'anchor_attrs_has_submenu'=> '',
			'anchor_attrs_submenu'=> '',
			'anchor_class'=> '',
			'anchor_class_has_submenu'=> '',
			'anchor_class_submenu'=> '',
			'menu_item_class'=> '',
			'menu_item_class_focus'=> '',
			'menu_item_class_has_submenu'=> 'dropdown',
			'menu_item_class_submenu'=> 'level2',
			'first_menu_item_class'=> '',
			'last_menu_item_class'=> '',
			'menu_class'=> 'nav navbar-nav',
			'menu_id'=> 'navbar',
			'before'=> '',
			'after'=> '',
			'link_before'=> '',
			'link_after'=> '',
			'depth'=> '10',
		]
		
	],
	'woo_checkout_fields'=> [
		'order_comments_input_class'=> ['form-control']
	],
	'woo_address_fields'=> [
		'input_class'=> ['form-control'],
		'label_class'=> ['control-label'],
		'form_row_class'=> ['row1']
	],
	
);