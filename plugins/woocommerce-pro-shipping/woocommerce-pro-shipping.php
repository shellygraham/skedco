<?php
/*
 Plugin Name: WooCommerce Pro Shipping
 Plugin URI: http://plugins.leewillis.co.uk/downloads/woocommerce-pro-shipping
 Description: Flexible shipping module for WooCommerce
 Version: 1.5.2
 Author: Lee Willis
 Author URI: http://plugins.leewillis.co.uk/
*/

/*
 This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, version 2.
 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 */

function woocommerce_pro_shipping_init() {

    // Don't do anything if WooCommerce isn't active
    if ( class_exists( 'Woocommerce' ) ) {
        require_once ( 'quote-engines/flat-rate.php' );
        require_once ( 'quote-engines/value-rate.php' );
        require_once ( 'quote-engines/weight-rate.php' );
        require_once ( 'quote-engines/quantity-rate.php' );
        require_once ( 'quote-engines/perproduct-rate.php' );

        if ( is_admin() ) {
            require_once ( 'woocommerce-pro-shipping-admin.php' );
            $woo_ps_pro_shipping_admin = new woo_ps_pro_shipping_admin();
        }

        // Only instantiate the module if the WooCommerce base class is available
        if ( class_exists( 'WC_Shipping_Method' ) ) {
            require_once( 'woocommerce-pro-shipping-module.php' );
        }
    }

}
add_action( 'plugins_loaded', 'woocommerce_pro_shipping_init', 0 );



function add_woo_pro_shipping_method( $methods ) {
    $methods[] = 'WC_Pro_Shipping';
    return $methods;
}
add_filter( 'woocommerce_shipping_methods', 'add_woo_pro_shipping_method' );


// Plugin updates
if ( !class_exists( 'PBLW_Plugin_Updater' ) ) {
	include( dirname( __FILE__ ) . '/PBLW-Plugin-Updater.php' );
}
new PBLW_Plugin_Updater(
	__FILE__,
	'woocommerce-pro-shipping'
);
