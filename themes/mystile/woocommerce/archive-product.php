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

$products_page_id = 424; // All this stuff is hard-coded to the "Products" page. So we can change the head/subhead/content/pic.
$post = get_post($products_page_id); 
$hero = wp_get_attachment_image_src(get_post_thumbnail_id($products_page_id),'category-hero');

// You tell if this is the top level by the existence of the var "get_query_var( 'term' )"
$top_level = (!get_query_var( 'term' )) ? TRUE : FALSE ;
$i = 1;

get_header('shop'); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
	?>

<?php if ($top_level) { ?>
<style>
.index-page-hero#product-index {
	background:url(<?php echo $hero[0] ?>) no-repeat bottom center;
	background-size:1063px auto !important;
}
</style>
<?php } ?>

	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		
	<?php if ($top_level) : ?>
	
	<?php hero_index_page_style() ?>

	<div class="index-page-hero" id="product-index">
		<span>
    		<h1 class="stacked"><?php echo get_field('headline', $products_page_id); ?></h1>
    		<h2 class="stacked"><?php echo get_field('subhead', $products_page_id); ?></h2>
    		<div class="index-cta" style="display:none;"><a href="" class="button2"><!--<?php echo get_field('button_text', 834); ?>--></a></div>
    	</span>
    </div>

	<div class="threecol-two">
		<h2 class=""><?php echo $post->post_title ?></h2>
	</div>
	<div class="threecol-one last">
		<p class="alignright"><?php echo $post->post_content ?></p>
	</div>
	<br class="clear" />
		
	<div class="woocommerce-tabs">
		<ul class="tabs">
			<li class="<?php if (!$_GET['t']) { ?>active<?php } ?>"><a href="<?php echo home_url("/shop") ?>">Type</a></li>
			<li class="<?php if ($_GET['t'] && !get_query_var( 'term' )) { ?>active<?php } ?>"><a href="<?php echo home_url("/shop?t=1") ?>">Industry</a></li>
		</ul>
		<hr class="fine" />
	</div>
			
	<?php
		if ($_GET['t'] && !get_query_var( 'term' )) {
			get_template_part( 'skedco', 'discipline-index' );
		} else if (!get_query_var( 'term' )) {
			get_template_part( 'skedco', 'category-index' );
		}
	?>

	<?php endif; ?>
	
	<?php endif; ?>
		
<?php if (get_query_var( 'term' )) { ?>
		<?php do_action( 'woocommerce_archive_description' ); ?>
		
		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				// do_action( 'woocommerce_before_shop_loop' );
				global $woocommerce_loop;
				$woocommerce_loop['columns'] = 4;
				$woocommerce_loop['grid'] = 'fourcol-one';
			?>

			<?php //woocommerce_product_loop_start(); ?>

				<?php //woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php 
						woocommerce_get_template_part( 'content', 'product' );
					?>

				<?php endwhile; // end of the loop. ?>

			<?php //woocommerce_product_loop_end(); ?>

			<br class="clear" />

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>
<?php } ?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action('woocommerce_sidebar');
	?>

<?php get_footer('shop'); ?>