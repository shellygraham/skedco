<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//First get "Cross Sells." Note: Cross-sell product MUST be "visible."	
	$cross_ids = get_post_meta( $post->ID, '_crosssell_ids', true );
	//say($cross_ids, 'cross ids');
	if ($cross_ids !== '') {
		$cross_args = array(
			'post_type'  => 'product', 
			'post__in'   => $cross_ids,
			'meta_key'   => '_visibility',
			'meta_value' => 'visible'
		);
		$cross_sells = new WP_Query( $cross_args );
		//say($cross_sells,'cross');

		// If there's one, it's called "post," if more than, "posts."
		$cross_posts = (is_array($cross_sells->post)) ? $cross_sells->post : array($cross_sells->post);
		$cross_posts = (is_array($cross_sells->posts)) ? $cross_sells->posts : array($cross_sells->posts);
	}

	// Now, if we need them, getting related (by category) products.
	
	$cats = get_the_terms( $post->ID, 'product_cat' ); // Using this on the page, that's why it's outside the condition.

	if (count($cross_posts) < 4) {
		foreach ( $cats as $cat ) $cats_array[] = $cat->term_id;
		$related_args = array( 'post__not_in' => array( $post->ID ), 'posts_per_page' => 4, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'tax_query' => array( 
    	array(
      	'taxonomy' => 'product_cat',
      	'field' => 'id',
      	'terms' => $cats_array
    	)));
		$related_products = new WP_Query( $related_args );
		//say($related_products,'related');
		
	}
	$related_posts = (is_array($related_products->post)) ? $related_products->post : array($related_products->post);
	$related_posts = (is_array($related_products->posts)) ? $related_products->posts : array($related_products->posts);
	
	$other_products = (isset($cross_posts)) ? array_merge((array)$cross_posts, (array)$related_posts) : (array)$related_posts;
	//say($other_products);
	
	
	wp_reset_query();
	$nsn = get_the_terms($product->id, 'pa_nsn');
	$nsn = current($nsn)->name;
?>
<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="threecol-one">
	<?php
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
	</div>
	<div class="threecol-two last summary entry-summary">
	

		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
			add_action('woocommerce_single_product_summary','woocommerce_template_single_meta',11);
			add_action( 'woocommerce_before_add_to_cart_button', 'popart_template_price', 10 );
			
			
			
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			
			
			do_action( 'woocommerce_single_product_summary' );
		?>

	<!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		 
		 //disqus_categories("product-reviews");
		do_action( 'woocommerce_after_single_product_summary' );

	?>
	</div>
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>

