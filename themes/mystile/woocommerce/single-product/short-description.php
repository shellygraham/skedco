<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

?>
<p itemprop="description">
	<?php echo apply_filters( 'woocommerce_short_description', get_the_excerpt() ) ?>
</p>