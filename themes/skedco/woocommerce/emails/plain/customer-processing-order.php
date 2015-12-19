<?php
/**
 * Customer processing order email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails/Plain
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo $email_heading . "\n\n";

echo __( "Congratulations on your purchase of some of the best rescue equipment available. Your order will be shipped ASAP! If there is a delay in your shipment, you will be notified by a Skedco Customer Service Representative in a timely manner. If you should need training on your product, we have videos and training partners who can help you. For all other questions or concerns, please give us a call at 800-770-7533 (8am-6pm Pacific Time, North America) or write us at skedco@skedco.com.\n\nTeam Skedco\n(503) 691-7909 ", 'woocommerce' ) . "\n\n";

echo "****************************************************\n\n";

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text );

echo sprintf( __( 'Order number: %s', 'woocommerce'), $order->get_order_number() ) . "\n";
echo sprintf( __( 'Order date: %s', 'woocommerce'), date_i18n( wc_date_format(), strtotime( $order->order_date ) ) ) . "\n";

do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text );

echo "\n" . $order->email_order_items_table( $order->is_download_permitted(), true, ($order->status=='processing') ? true : false, '', '', true );

echo "----------\n\n";

if ( $totals = $order->get_order_item_totals() ) {
	foreach ( $totals as $total ) {
		echo $total['label'] . "\t " . $total['value'] . "\n";
	}
}

echo "\n****************************************************\n\n";

do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text );

echo __( 'Your details', 'woocommerce' ) . "\n\n";

if ( $order->billing_email )
	echo __( 'Email:', 'woocommerce' ); echo $order->billing_email . "\n";

if ( $order->billing_phone )
	echo __( 'Tel:', 'woocommerce' ); ?> <?php echo $order->billing_phone . "\n";

wc_get_template( 'emails/plain/email-addresses.php', array( 'order' => $order ) );

echo "\n****************************************************\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );