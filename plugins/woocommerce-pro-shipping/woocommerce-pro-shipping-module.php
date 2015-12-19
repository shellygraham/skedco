<?php

class WC_Pro_Shipping extends WC_Shipping_Method {



	private $woo_ps_settings;



	function __construct() {
		$this->id			= 'pro-shipping';
		$this->method_title = __( 'Pro Shipping', 'woo_ps' );
		$this->init();
		$this->woo_ps_settings = get_option( 'woo_ps' );
		//add_action ( 'wp', array ( &$this, 'errorlog'));
	}



	function errorlog() {

		global $woocommerce;

		error_log( 'cart_contents_total : ' .  $woocommerce->cart->cart_contents_total );
		error_log( 'cart_contents_tax : ' .  $woocommerce->cart->cart_contents_tax );
		error_log( 'total : ' .  $woocommerce->cart->total );
		error_log( 'subtotal : ' .  $woocommerce->cart->subtotal );
		error_log( 'subtotal_ex_tax : ' .  $woocommerce->cart->subtotal_ex_tax );
		error_log( 'tax_total : ' .  $woocommerce->cart->tax_total );
		error_log( 'discount_cart : ' . $woocommerce->cart->discount_cart );
		error_log( 'discount_total : ' . $woocommerce->cart->discount_total );


	}



    function init() {

		// Load the form fields.
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();

		// This is controlled through the WooCommerce settings API
		$this->enabled		= $this->settings['enabled'];
		$this->title		= $this->method_title;

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}



	/**
	 * Settings content on WooCommerce Shipping Settings page
	 */
	function init_form_fields() {

    	global $woocommerce;

    	$this->form_fields = array(
			'enabled' => array(
				'title' 		=> __( 'Enable/Disable', 'woocommerce' ),
				'type' 			=> 'checkbox',
				'label' 		=> __( 'Enable this shipping method', 'woocommerce' ),
				'description'	=> '<a href="admin.php?page=woo-pro-shipping-settings">' . __( 'Click to configure rates.', 'woo_ps' ) . '</a>',
				'default' 		=> 'on',
			),
		);

	}



	/**
	 * Settings content on WooCommerce Shipping Settings page
	 */
	function admin_options() {

		global $woocommerce; ?>

		<h3><?php echo $this->method_title; ?></h3>
		<table class="form-table">
		<?php
    		// Generate the HTML For the settings form.
    		$this->generate_settings_html();
    		?>
    	</table><?php

	}



	/* Try and generate a quote for this specific rate for the current cart */
	private function calculate_quote( & $rate, $rate_id ) {

		switch ( $rate['type'] ) {
			case 'flat':
				$quote_engine = new woo_ps_flat_rate( $rate );
				break;
			case 'weight':
				$quote_engine = new woo_ps_weight_rate( $rate );
				break;
			case 'value':
				$quote_engine = new woo_ps_value_rate( $rate );
				break;
			case 'quantity':
				$quote_engine = new woo_ps_quantity_rate( $rate );
				break;
			case 'perproduct':
				$quote_engine = new woo_ps_perproduct($rate);
				break;
			default:
				return array();
				break;
		}

		$rate_quotes = $quote_engine->get_quotes();

		//if ( count ( $rate_quotes ) ) {
			//$rate_quotes = apply_filters ( 'ses_ps_overrides', $rate_quotes, $rate, $rate_id );
		//}

		return $rate_quotes;
	}



	function calculate_shipping() {

		global $woocommerce;

		$all_quotes = array();

		foreach ( $this->woo_ps_settings['rates'] as $rate_id => $rate ) {
			if ( $this->rate_is_available( $rate, $rate_id ) ) {
				$rate_quotes = $this->calculate_quote( $rate, $rate_id );
				// This rate didn't produce a quote - try the next
				if ( ! count( $rate_quotes ) )
					continue;
				$rate_quote_count = 0;
				foreach ( $rate_quotes as $quote ) {
					// Enforce a unique display name for each quote
					list( $name, $value ) = each( $quote );
					while ( isset ( $all_quotes[$name] ) ) {
						$name .= ' ';
					}
					$all_quotes[$name] = array(
						'id' => 'wooo-pro-shipping-'.$rate_id.'-'.$rate_quote_count,
						'label' => $name,
						'cost' => $value,
						);
					$rate_quote_count++;
				}
			}
		}

		foreach ( $all_quotes as $quote ) {
			$this->add_rate( $quote );
		}

	}



	private function rate_is_available_for_country( & $rate ) {

		global $woocommerce;

		if ( ! isset ( $rate['countries'] ) )
			return false;

		$valid_countries = $rate['countries'];

		if ( ! is_array( $valid_countries ) || ! count( $valid_countries ) )
			return false;

		return in_array( $woocommerce->customer->get_shipping_country(), $valid_countries );
	}



	private function rate_is_available_for_state( & $rate ) {

		global $woocommerce;

		if ( ! isset ( $rate['states'] ) )
			return false;

		$valid_states = $rate['states'];

		if ( ! is_array( $valid_states ) || ! count( $valid_states ) )
			return false;

		$composite_key = $woocommerce->customer->get_shipping_country() . '|' . $woocommerce->customer->get_shipping_state();

		return in_array( $composite_key, $valid_states );

	}



	private function rate_is_available( & $rate, $rate_id ) {

		global $woocommerce;

		switch ( $rate['availability'] ) {
			case 'all':
				$availability = true;
				break;
			case 'countries':
				$availability = $this->rate_is_available_for_country( $rate );
				break;
			case 'states':
				$availability = $this->rate_is_available_for_state( $rate );
				break;
			default:
				$availability = false;
				break;

		}

		return apply_filters( 'woo_ps_availability', $availability, $rate, $rate_id );

	}



	function is_available( $package = array() ) {

    	global $woocommerce;

    	if ( $this->enabled == 'no' )
    		return false;

		// Loop through rates
		foreach ( $this->woo_ps_settings['rates'] as $rate_id => $rate ) {
			// Check if rate is available for the customer. If so - return it - no need to ccheck the others
			if ( $this->rate_is_available( $rate, $rate_id ) )
				return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', true, $package );
		}

    	// Return false since none available
		return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', false, $package );
    }

}