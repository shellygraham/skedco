<?php
/**
 * Plugin Name: WooCommerce - List Products by Tags
 * Plugin URI: http://www.remicorson.com/list-woocommerce-products-by-tags/
 * Description: List WooCommerce products by tags using a shortcode, ex: [woo_products_by_tags tags="shoes,socks"]
 * Version: 1.0
 * Author: Remi Corson
 * Author URI: http://remicorson.com
 * Requires at least: 3.5
 * Tested up to: 3.5
 *
 * Text Domain: -
 * Domain Path: -
 *
 */
 
/*
 * List WooCommerce Products by tags
 *
 * ex: [woo_products_by_tags tags="shoes,socks"]
 */
function woo_products_by_tags_shortcode( $atts, $content = null ) {
  
	// Get attribuets
	extract(shortcode_atts(array(
		"tags" => '',
		"per_page" => ''
	), $atts));
	
	ob_start();
 
	// Define Query Arguments
	$args = array( 
				'post_type' 	 => 'product', 
				'posts_per_page' => $atts['per_page'], 
				'product_tag' 	 => $tags 
				);
	
	// Create the new query
	$loop = new WP_Query( $args );
	
	// Get products number
	$product_count = $loop->post_count;
	
	// If results
	if( $product_count > 0 ) :
	
		echo '<ul class="products">';
		
			// Start the loop
			while ( $loop->have_posts() ) : $loop->the_post(); global $product;
			
				global $post;
				
				echo "<p>" . $thePostID = $post->post_title. " </p>";
				
				if (has_post_thumbnail( $loop->post->ID )) 
					echo  get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); 
				else 
					echo '<img src="'.$woocommerce->plugin_url().'/assets/images/placeholder.png" alt="" width="'.$woocommerce->get_image_size('shop_catalog_image_width').'px" height="'.$woocommerce->get_image_size('shop_catalog_image_height').'px" />';
		
			endwhile;
		
		echo '</ul><!--/.products-->';
	
	else :
	
		_e('No product matching your criteria.');
	
	endif; // endif $product_count > 0
	
	return ob_get_clean();
 
}
 
add_shortcode("woo_products_by_tags", "woo_products_by_tags_shortcode");

?>