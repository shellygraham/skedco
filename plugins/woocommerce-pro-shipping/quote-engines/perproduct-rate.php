<?php

if ( ! class_exists( 'woo_ps_perproduct' ) ) {
	class woo_ps_perproduct {

		private $settings = '';

		function __construct( $rate ) {
			$this->settings = $rate;
		}

		function get_quotes() {
			global $woocommerce;

			$settings = $this->settings;
			$perproduct_settings = $settings['options']['perproduct'];
			$blankiszero = ( $perproduct_settings['missingprices'] == 'zero' ) ? TRUE : FALSE;
			$subtotal = 0;

			// Foreach cart item
            if ( empty ( $woocommerce->cart->cart_contents ) ) {
                return array();
            }

			foreach ( $woocommerce->cart->cart_contents as $cart_item ) {
				if ( isset( $perproduct_settings[$cart_item['product_id']] ) &&
					 isset( $perproduct_settings[$cart_item['product_id']]['first'] ) &&
					 $perproduct_settings[$cart_item['product_id']] != '' &&
					 $perproduct_settings[$cart_item['product_id']]['first'] != '' ) {
					$subtotal += $perproduct_settings[$cart_item['product_id']]['first'];
					if ( $cart_item['quantity'] > 1 ) {
						$subtotal += ( $perproduct_settings[$cart_item['product_id']]['others'] * ( $cart_item['quantity'] - 1 ) );
					}
                } elseif ( $blankiszero ) {
					// Rate is configured to quote $0 if any products are missing prices
					continue;
				} else {
					// Rate is configured to not quote if any products are missing prices
					return array();
				}
			}
			return array( array( $this->settings['user_facing_name'] => (float) $subtotal) );
		}
	}
}
