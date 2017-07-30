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
	
	//move to woocommerce/custom/
	//'widget_shopping_cart_button_view_cart'=> '<a href="%s" class="button wc-forward">%s</a>',
	//'widget_shopping_cart_proceed_to_checkout'=> '<a href="%s" class="button checkout wc-forward">%s</a>',
	
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
	'yoast_breadcrumb'=> [
		'separator'=> '/'
	],
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
	'checkout_fields'=> [
		'order_comments_input_class'=> ['form-control']
	],
	'address_fields'=> [
		'input_class'=> ['form-control'],
		'label_class'=> ['control-label'],
		'form_row_class'=> ['row1']
	],
	'sidebars'=> [
		'sidebar-footer'=> [
			'before_widget'=> '<div class="%2$s *1 col-md-2" id="%1$s">',
			'before_title'=> '<h3 class="%2$s" style="{css_title};">',
			'after_title'=> '</h3><div class="infomation">',
			'after_widget'=> '</div></div>',
			'description'=> '',
		]
	]
);