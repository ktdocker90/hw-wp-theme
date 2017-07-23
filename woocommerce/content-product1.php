<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $post;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php post_class(); ?>>
	<a href="<?php echo get_the_permalink() ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
		
		<?php woocommerce_show_product_sale_flash()?>

		<?php woocommerce_template_loop_product_thumbnail() ?>

		<h2 class="woocommerce-loop-product__title"><?php the_title() ?></h2>

		<?php woocommerce_template_loop_rating() ?>
		
		<?php woocommerce_template_loop_price() ?>

	</a>
	<?php woocommerce_template_loop_add_to_cart() ?>
</li>
