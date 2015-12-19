<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
 
<?php 
	// Getting hero image, if it's not a child of "Industry Solutions," (i.e. "product_tag" archive) we'll load a random one.
	$queried_object = get_queried_object();
	if ($queried_object->taxonomy == "product_tag") {
		$product_tag_hero = get_field('hero_image', $queried_object->taxonomy . '_' . $queried_object->term_id);
		$hero_img = $product_tag_hero['url']; 
	} else {
		$hero_img = get_skedco_random_hero_img();
	}
	
	// Getting posts
?>


	<div class="masthead <?php echo $queried_object->taxonomy ?>">
		<img src="<?php echo $hero_img ?>" />
<?php if ($queried_object->taxonomy == "product_tag") { ?>

		<div class='container'><h1><?php echo $queried_object->name ?></h1>
		<h2 id="industry-solutions"><?php echo get_field('subhead', $queried_object->taxonomy . '_' . $queried_object->term_id) ?></h2></div>
		<p><?php echo $queried_object->description ?></p>

<?php } ?>
	</div>


	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php if (!$queried_object->taxonomy == "product_tag") { ?>
		<?php add_action('the_content', 'remove_paragraph_tags'); ?>
		<h3><?php do_action( 'woocommerce_archive_description' ); ?></h3>
		<?php } ?>
		

		<?php if ( have_posts() ) : ?>
			<div id="results-text-wrap">
			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			</div>
			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
		
	?>


	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>