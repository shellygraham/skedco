<?php

if ( ! class_exists ( 'woo_ps_value_rate' ) ) {

	class woo_ps_value_rate {


		private $settings = '';


		function __construct( &$rate ) {

			$this->settings = $rate;

		}



		function cart_value() {

			global $woocommerce;

			// Total after discounts, but including tax
			return $woocommerce->cart->cart_contents_total + $woocommerce->cart->tax_total - $woocommerce->cart->discount_total;

		}



		function get_quotes() {

			if ( ! isset ( $this->settings['options']['value']['rates'] ) )
				return array();

			$layers = $this->settings['options']['value']['rates'];
			$cart_value = $this->cart_value();
			
			foreach ( $layers as $key => $shipping ) {

				if ( $cart_value >= (float) $key ) {

					return array ( array ( $this->settings['user_facing_name'] => (float) $shipping) );

				}

			}
			return array();

		}


	}

}
