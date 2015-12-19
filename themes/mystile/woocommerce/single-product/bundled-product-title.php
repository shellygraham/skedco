<?php
/**
 * Bundled Product Title
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<!--<li class="bundled_product_title product_title">-->
	<a href="<?php echo get_permalink($product->post->ID) ?>">
	<?php
		//printf('%s of %s - ', $loop_count, $bundle_count);
		if ($sku) { echo $sku . ' '; }
		$title = ( $custom_title !== '' ) ? $custom_title : $product->post->post_title;
		echo __( $title ) . ( ( $quantity > 1 ) ? ' &times; '. $quantity : '' );
	?>
	</a>
<!--</li>-->
