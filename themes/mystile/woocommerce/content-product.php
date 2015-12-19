<?php
	global $product, $woocommerce_loop;
	
	$cat_id = current(wp_get_object_terms($post->ID, 'product_cat'))->term_id;
	$cat_color = get_field('color', 'product_cat_'.$cat_id); 
	
	// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();

// Class to make the .js rollover work.
$classes[] = 'product-rollover';

if ( isset($woocommerce_loop['grid']) ) 
	$classes[] = $woocommerce_loop['grid'];

if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
	

	$img = get_the_post_thumbnail($post->ID, 'square250');
	if (!$img) { $img = "<img src='/wordpress/wp-content/plugins/woocommerce/assets/images/placeholder.png' />"; }
	$see_more = ' <a href="' . get_permalink() . '">[...]</a>';
?>

		<div <?php post_class( $classes ); ?>>
		<?php if (!isset($post->options->unwrapped)) { ?>
			<!--<li <?php post_class( $classes ); ?>>-->
		<?php } ?>

				<div class="show">
					<a href="<?php the_permalink() ?>">
						<?php echo $img; ?>

						<strong class="short"><?php echo wp_trim_words(get_the_title(),4, '...') ?></strong>
					</a>
				</div>
				
				<div class="hide">
					<a href="<?php the_permalink() ?>">
						<?php echo $img; ?>

						<strong class="full"><?php echo get_the_title() ?></strong>
					</a>
					<p class="reading-font"><?php echo wp_trim_words(get_the_excerpt(),12, $see_more) ?></p>
					<span class="product-price" style="background:<?php echo $cat_color ?> !important;"><?php echo do_shortcode('[skedco_msrp]') ?> <?php echo $product->get_price_html(); ?></span>
				</div>
	
		<?php if (!isset($post->options->unwrapped)) { ?>
			<!--</li>-->
		<?php } ?>
			</div>
		