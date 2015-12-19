<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/*
  Plugin Name: Skedco - Current User Info
  Description: Putting together the ideas of "Customer" and "Commenter."
  Author: CJ Stritzel
  Version: 1.0
 */

function skedco_is_commenter_customer() { 
	$current_user = wp_get_current_user();
	$meta = get_user_meta($current_user->data->ID);
	$_ = (object)array(
		'shipping_address'           => $meta['shipping_address_1'][0],
		'billing_first'              => $meta['billing_first_name'][0],
		'billing_last'               => $meta['billing_last'][0],
		'wp_first'                   => $meta['first_name'][0],
		'wp_last'                    => $meta['last_name'][0],
		'cart'                       => current(unserialize($meta['_woocommerce_persistent_cart'][0])),
		'facebookall_user_id'        => $meta['facebookall_user_id'][0],
		'facebookall_user_email'     => $meta['facebookall_user_email'][0],
		'facebookall_user_thumbnail' => $meta['facebookall_user_thumbnail'][0]
	);
	$_->has_facebook = ($_->facebookall_user_id != '') ? true : false ;
	// 'cart' is the value '_woocommerce_persistent_cart'
	// say($meta);
	// say($_);
	return $_;
} 
add_action('wp_head','skedco_is_commenter_customer');
 
 
 ?>