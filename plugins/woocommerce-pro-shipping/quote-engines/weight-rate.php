<?php

if ( ! class_exists ( 'woo_ps_weight_rate' ) ) {

	class woo_ps_weight_rate {


		private $settings = '';


		function __construct( &$rate ) {

			$this->settings = $rate;

		}



		/**
		 * Accepts a $weight which is in the main WooCommerce weight units UOM
		 * Outputs that $weight in the specified $units)
		 * Valid units are:
		 *     - kg
		 *     - g
		 *     - lbs
		 */
		private function convert_weight ($weight, $from_units, $to_units) {

			// First convert the weight to grams
			switch ( $from_units ) {
				case 'g':
					$weight = $weight;
					break;
				case 'kg':
					$weight = $weight * 1000;
					break;
				case 'lbs':
					$weight = $weight * 453.59237;
					break;
				case 'oz':
					$weight = $weight * 28.3495;
					break;
			}

			// Convert the weight in grams to the desired output format
			switch ( $to_units ) {
				case 'g':
					$output = $weight;
					break;
				case 'kg':
					$output = $weight / 1000;
					break;
				case 'lbs':
					$output = $weight * 0.00220462262;
					break;
				case 'oz':
					$output = $weight * 0.035274;
					break;
				default:
					$output = $weight;
					break;
			}

			return $output;

		}


		function get_quotes() {

			global $woocommerce;

			if ( ! isset ( $this->settings['options']['weight']['rates'] ) ) {
				return array();
			} else {
				$layers = $this->settings['options']['weight']['rates'];
			}

			if ( ! count ( $layers ) ) {
				return Array();
			}

			if ( ! isset ( $this->settings['options']['weight']['calc_type'] ) ) {
				$calc_type = 'total';
			} else {
				$calc_type = $this->settings['options']['weight']['calc_type'];
			}

			if ( ! isset ( $this->settings['options']['weight']['units'] ) ) {
				$weight_band_units = 'pound';
			} else {
				$weight_band_units = $this->settings['options']['weight']['units'];
			}

			if ( $calc_type == 'total' ) {

				// Get the cart weight
				$weight = $woocommerce->cart->cart_contents_weight;

				// Note the weight layers are sorted before being saved into the options
				// Here we assume that they're in (descending) order, we convert the weights
				// on the fly to the general rate as set in WC settingswhich is what the
				// cart weight is stored as

				foreach ( $layers as $key => $shipping ) {

					$key = $this->convert_weight ( $key, $weight_band_units, get_option ( 'woocommerce_weight_unit' ) );

					if ( $weight >= (float) $key ) {

						return array ( array ( $this->settings['user_facing_name'] => (float) $shipping) );

					}

				}

				// We couldn't find a rate - exit out.
				return Array();

			} else {

				return Array();

				/*
				 * Other weight calculation methods not implemented yet

				if (isset($wpsc_cart) && isset($wpsc_cart->cart_items) && count($wpsc_cart->cart_items)) {

					$subtotal = 0;
					foreach ($wpsc_cart->cart_items as $cart_item) {

						foreach ($layers as $key => $shipping) {

							if ($calc_type == 'items') {

								if ($cart_item->weight >= (float)$key) {
									$subtotal += (float)($shipping * $cart_item->quantity);
									break;
								}

							} elseif ($calc_type == 'consolidateditems') {

								if (($cart_item->weight * $cart_item->quantity) >= (float)$key) {
									$subtotal += (float)$shipping;
									break;
								}

							}

						}

					}

					return array ( array ( $this->settings['user_facing_name'] => (float) $subtotal) );

				}

			*/
			}

		}

	}

}
