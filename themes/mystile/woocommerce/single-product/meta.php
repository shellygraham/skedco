<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
$nsn = get_the_terms($product->id, 'pa_nsn');
//say($nsn);
$nsn = current($nsn)->name;
$cat_color = get_field('color', 'product_cat_'.current(get_the_terms( $post->ID, 'product_cat' ))->term_id);

$cat_icons = array();
foreach (get_the_terms( $post->ID, 'product_cat' ) as $c) {
	$cat_icons[] = sprintf('<a href="%s/product-category/%s" class="icon"><img src="/icons/%s.png" title="View more products in \'%s\'" alt="%s Icon" /></a>',get_home_url(),$c->slug,$c->slug,$c->name,$c->name);
}

?>
<div class="product_meta">

	<div class="floatright">

	<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option( 'woocommerce_enable_sku' ) == 'yes' && $product->get_sku() ) : ?>
		<span itemprop="productID" class="sku_wrapper">
			SKU:  <span class="sku"><?php echo $product->get_sku(); ?></span>
			<?php if ($nsn) { ?><br />NSN: <span class="nsn"><?php echo $nsn; ?></span><?php } ?>
		</span>
	<?php endif; ?>
	</div>
	<div class="floatleft">
	<?php
		printf('<div class="left">%s</div>', implode("\n",$cat_icons));
		//say(current(get_the_terms( $post->ID, 'product_cat' ))->slug);
		//printf('<a class="cat-button" href="%s%s" style="background:%s !important;"><small>See all Products in:</small>%s</a>', home_url('/product-category/'), current(get_the_terms( $post->ID, 'product_cat' ))->slug,$cat_color,current(get_the_terms( $post->ID, 'product_cat' ))->name);
		//printf('[<a href="%s%s">%s.jpg</a>]', home_url('/product-category/'),current(get_the_terms( $post->ID, 'product_cat' ))->slug,current(get_the_terms( $post->ID, 'product_cat' ))->slug);
		// $size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
		// echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $size, 'woocommerce' ) . ' ', '.</span>' );
	?>

	<?php
		// $size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
		// echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $size, 'woocommerce' ) . ' ', '.</span>' );
	?>

	</div>
	<br class="clear" />
</div>