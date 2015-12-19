<?php

if ( ! class_exists ( 'woo_ps_quantity_rate' ) ) {

	class woo_ps_quantity_rate {


		private $settings = '';


		function __construct( &$rate ) {

			$this->settings = $rate;

		}


		function num_items() {

			global $woocommerce;

			// Because we like double negatives - sigh ...
			$all_products = ! $this->settings['options']['quantity']['exclude_no_shipping'];

			$num_items = 0;

			if ( $all_products ) {

				$num_items = $woocommerce->cart->cart_contents_count;
				
			} else {

				$num_items = 0;

				foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {

					$_product = $values['data'];

					if ( $_product->virtual != 'yes' ) {
						$num_items += $values['quantity'];
					}

				}

			}

			return $num_items;

		}



		function get_quotes() {

			if ( ! isset ( $this->settings['options']['quantity']['rates'] ) )
				return array();

			$layers = $this->settings['options']['quantity']['rates'];

			$num_items = $this->num_items();

			foreach ( $layers as $key => $shipping ) {

				if ( $num_items >= (float) $key ) {

					return array ( array ( $this->settings['user_facing_name'] => (float) $shipping) );

				}

			}
			return array();

		}


	}

}
