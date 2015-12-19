<?php

if ( ! class_exists ( 'woo_ps_pro_shipping_admin' ) ) {

	class woo_ps_pro_shipping_admin {

		var $admin_url = '';
		private $settings = '';
		private $setting_keys = array( 'admin_facing_name', 'user_facing_name', 'availability', 'countries', 'states', 'type' );
		private $wc_countries;

		function __construct() {
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
			add_action( 'init', array( &$this, 'init' ) );
			add_action( 'admin_menu', array( &$this, 'add_menu' ) );
			$this->settings = get_option( 'woo_ps' );
		}

		function init() {
			if ( ! isset ( $this->wc_countries ) )
				$this->wc_countries = new WC_Countries();
		}

		function admin_init() {
			load_plugin_textdomain( 'woo_ps', false, basename( dirname( __FILE__ ) ) . '/languages' );
			add_action( 'add_meta_boxes_product', array( $this, 'add_meta_boxes') );
			add_action( 'woocommerce_process_product_meta', array( $this, 'save_meta' ), 10, 2 );
		}

		function add_menu() {
			if ( current_user_can( 'manage_options' ) ) {
				$page = add_submenu_page( 'woocommerce', __( 'Pro Shipping', 'woo_ps' ), __( 'Pro Shipping', 'woo_ps' ), 'manage_options', 'woo-pro-shipping-settings', array( &$this, 'admin_page' ) );
				$this->admin_url = 'admin.php?page=woo-pro-shipping-settings';
				add_action( 'admin_print_styles-' . $page, array( &$this, 'enqueue_scripts' ) );
			}
			return;
		}

		private function wrap_content_with_currency( $content, $in_js = false ) {
			$currency_pos = get_option( 'woocommerce_currency_pos' );
			$currency_symbol = get_woocommerce_currency_symbol();
			if ( $in_js )
				$currency_symbol = str_replace( '"', '\"', $currency_symbol );
			switch ($currency_pos) :
				case 'left_space' :
					$return = $currency_symbol . '&nbsp;' . $content;
				break;
				case 'right' :
					$return = $content . $currency_symbol;
				break;
				case 'right_space' :
					$return = $content . '&nbsp;' . $currency_symbol;
				break;
				case 'left' :
				default:
					$return = $currency_symbol . $content;
			endswitch;
			return $return;
		}

		function has_per_product_shipping() {
			if ( isset ( $this->settings['rates'] ) ) {
				foreach ( $this->settings['rates'] as $rate_id => $rate ) {
					if ( $rate['type'] == 'perproduct' ) {
						return TRUE;
					}
				}
			}
			return FALSE;
		}

		function add_meta_boxes() {
			if ( $this->has_per_product_shipping() ) {
				add_meta_box(
					'woo-ps-perproduct',
					__( 'Pro Shipping - Per-Product Shipping', 'woo_ps' ),
					array( $this, 'per_product_shipping_metabox' ),
					'product',
					'advanced',
					'high'
				);
			}
		}

		function per_product_shipping_metabox() {
			global $post;
			if ( isset ( $this->settings['rates'] ) ) {
				foreach ( $this->settings['rates'] as $rate_id => $rate ) {
					if ( $rate['type'] != 'perproduct' )
						continue;
					?>
					<label for="woo_ps_perproduct[<?php esc_attr_e( $rate_id ); ?>]"><strong><?php esc_html_e( $rate['admin_facing_name'] ); ?></strong></label></br>
					<?php
					if ( isset( $rate['options']['perproduct'][$post->ID] ) ) {
						$value = $rate['options']['perproduct'][$post->ID];
					} else {
						$value = array( 'first' => '', 'others' => '' );
					} ?>
					<?php _e( 'First item: ', 'woo_ps' ); ?>
					<?php
						echo $this->wrap_content_with_currency( "<input type='text' size='5' name='woo_ps_perproduct[". esc_attr( $rate_id ) . "][first]' value='" .  esc_attr( $value['first'] ) . "'>" );
					?>
					<br/>
					<?php _e( 'Each additional item: ', 'woo_ps' ); ?>
					<?php
						echo $this->wrap_content_with_currency( "<input type='text' size='5' name='woo_ps_perproduct[" . esc_attr( $rate_id ) . "][others]' value='" . esc_attr( $value['others'] ) . "'>" );
					?>
					<?php
					echo '<br/><br/>';
				}
				$inheritance = get_post_meta( $post->ID, '_woo_ps_perproduct_inheritance', true );
				if ( empty ( $inheritance ) ) {
					$inheritance = 'no';
				}
				// echo '<input type="radio" name="woo_ps_perproduct_inheritance" value="no" ' . checked( 'no', $inheritance, false ) . '> ' . __( 'Prices are set individually against each variation', 'woo_ps' ) . '<br>';
				echo '<input type="hidden" name="woo_ps_perproduct_inheritance" value="' . esc_attr_e( $inheritance ) . '">';
			}
		}

		function save_meta( $post_id, $post ) {
			if ( $this->has_per_product_shipping() && isset( $_POST['woo_ps_perproduct'] ) ) {
				foreach ( $_POST['woo_ps_perproduct'] as $rate_id => $price ) {
					$this->settings['rates'][$rate_id]['options']['perproduct'][$post_id] = $price;
				}
			}
			update_option( 'woo_ps', $this->settings );
			if ( isset ( $_POST['woo_ps_perproduct_inheritance'] ) ) {
				update_post_meta( $post_id, '_woo_ps_perproduct_inheritance', $_POST['woo_ps_perproduct_inheritance'] );
			}
		}

		function enqueue_scripts() {
			wp_enqueue_style( 'woo-ps', WP_PLUGIN_URL . '/woocommerce-pro-shipping/html/woo-ps.css' );
		}

		function get_rates() {
			return $this->settings['rates'];
		}

		function get_rate( $id ) {
			if ( isset( $this->{'settings'}['rates'] ) ) {
				return $this->{'settings'}['rates'][$id];
			} else {
				return FALSE;
			}
		}

		function get_countries() {
			return $this->wc_countries->get_allowed_countries();
		}

		function list_countries( $selected ) {
			// If not configured, select all by default.
			if ( ! $selected )
				$select_all = TRUE ;
			else
				$select_all = FALSE;
			?>
			<select size="18" name="countries[]" multiple>
			<?php
				$countries = $this->get_countries();

				foreach ( $countries as $code => $name ) {
					$key = esc_attr( $code );
					echo '<option ';
					if ( $select_all || in_array( $key, $selected ) )
						echo 'selected="on" ';
					echo "value='$key'>";
					esc_html_e( $name );
					echo '</option>';
				}
			?>
			</select>
			<?php
		}

		function get_states() {
			foreach ( $this->get_countries() as $code => $name ) {
				if ( $states = $this->wc_countries->get_states( $code ) ) {
					$return[$code] = $states;
				}
			}
			return $return;
		}

		function list_states( $selected ) {
			$countries = $this->get_countries();
			// If not configured, select all by default.
			if ( ! $selected )
				$select_all = TRUE ;
			else
				$select_all = FALSE;
			?>
			<select size="10" style="height: 10em;" name="states[]" multiple>
			<?php
				$all_states = $this->get_states();
				foreach ( $all_states as $country_code => $states ) {
					echo '<option name="" value="" disabled>' . esc_html( $countries[$country_code] ) . '</option>';
					foreach ( $states as $state_code => $state_name ) {
						$key = $country_code . '|' . $state_code;

						echo '<option ';
						if ( $select_all || in_array( $key, $selected ) )
							echo 'selected="on" ';
						echo 'value="' . esc_attr( $key ) . '">&nbsp;&nbsp;';
						esc_html_e( $state_name );
						echo '</option>';
					}
				}
			?>
			</select>
			<?php
		}

		function show_weight_units( $unit_type, $esc_quotes = FALSE ) {
			if ( $esc_quotes )
				echo '<span class=\"weight_unit_desc\">';
			else
				echo '<span class="weight_unit_desc">';
			if ( $unit_type == 'lbs' )
				_e( 'lbs', 'woo_ps' );
			else if ( $unit_type == 'g' )
				_e( 'g', 'woo_ps' );
			else if ( $unit_type == 'kg' )
				_e( 'kg', 'woo_ps' );
			echo '</span>, ';
		}

		function delete_rate() {
			check_admin_referer( 'woo_ps_delete_rate' );
			if ( ! isset( $_POST['rate_id'] ) || ! is_numeric( $_POST['rate_id'] ) ) {
				wp_die( __( 'Rate not found.', 'woo_ps' ) );
			}
			$settings = &$this->settings;
			if ( isset( $settings['rates'][$_POST['rate_id']] ) ) {
				if ( isset( $settings['rates'][$_POST['rate_id']]['admin_facing_name'] ) ) {
					$rate_description = $settings['rates'][$_POST['rate_id']]['admin_facing_name'];
				} else {
					$rate_description = 'Rate';
				}
				unset ( $settings['rates'][$_POST['rate_id']] );
				update_option( 'woo_ps', $settings );
				echo '<div id="message" class="updated"><p>&quot;' . esc_html( $rate_description ) . '&quot;' . __( ' removed.', 'woo_ps' ) . '</p></div>';
			}
		}

		function edit_rate() {
			if ( ! isset( $_POST['rate_id'] ) || ! is_numeric( $_POST['rate_id'] ) )
				$adding = TRUE;
			else
				$adding = FALSE;

			if ( empty ( $_POST['admin_facing_name'] ) )
				$_POST['admin_facing_name'] = __( 'Un-named rate', 'woo_ps' );

			if ( empty ( $_POST['user_facing_name'] ) )
				$_POST['user_facing_name'] = __( 'Shipping', 'woo_ps' );

			if ( $adding ) {
				$rate = array();
			} else {
				$settings = $this->settings;
				$rate = $settings['rates'][$_POST['rate_id']];
			}

			// Simple config
			foreach ( $this->setting_keys as $key ) {
				if ( isset ( $_POST[$key] ) )
					$rate[$key] = $_POST[$key];
			}

			//Other config
			if ( isset ( $_POST['flat_rate'] ) )
				$rate['options']['flat']['rate'] = $_POST['flat_rate'];

			// Deal with weight rate config
			if ( isset ( $_POST['weight_units'] ) )
				$rate['options']['weight']['units'] = $_POST['weight_units'];

			if ( isset ( $_POST['calc_type'] ) )
				$rate['options']['weight']['calc_type'] = $_POST['calc_type'];

			$new_weight_bands = array();

			if ( isset( $_POST['weights'] ) ) {
				for ( $i = 0; $i < count( $_POST['weights'] ); $i++ ) {
					// Don't set rates if they're blank
					if ( isset( $_POST['weight_rates'][$i] ) && $_POST['weight_rates'][$i] != '' ) {
						$new_weight_bands[$_POST['weights'][$i]] = $_POST['weight_rates'][$i];
					}
				}
			}

			if ( count( $new_weight_bands ) ) {
				krsort( $new_weight_bands, SORT_NUMERIC );
			}

			$rate['options']['weight']['rates'] = $new_weight_bands;

			// Deal with order value band config
			$new_value_bands = array();

			if ( isset( $_POST['values'] ) ) {
				for ( $i = 0; $i < count( $_POST['values'] ); $i++ ) {
					// Don't set rates if they're blank
					if ( isset( $_POST['value_rates'][$i] ) && $_POST['value_rates'][$i] != '' ) {
						$new_value_bands[$_POST['values'][$i]] = $_POST['value_rates'][$i];
					}
				}
			}
			if ( count( $new_value_bands ) ) {
				krsort( $new_value_bands, SORT_NUMERIC );
			}
			$rate['options']['value']['rates'] = $new_value_bands;

			// Deal with quantity band config
			if ( isset ( $_POST['qty_exclude_no_shipping'] ) ) {
				if ( $_POST['qty_exclude_no_shipping'] == 'yes' ) {
					$rate['options']['quantity']['exclude_no_shipping'] = TRUE;
				} else {
					$rate['options']['quantity']['exclude_no_shipping'] = FALSE;
				}
			}

			$new_quantity_bands = array();

			if ( isset( $_POST['quantities'] ) ) {
				for ( $i = 0; $i < count( $_POST['quantities'] ); $i++ ) {
					// Don't set rates if they're blank
					if ( isset( $_POST['quantity_rates'][$i] ) && $_POST['quantity_rates'][$i] != '' ) {
						$new_quantity_bands[$_POST['quantities'][$i]] = $_POST['quantity_rates'][$i];
					}
				}
			}
			if ( count( $new_quantity_bands ) ) {
				krsort( $new_quantity_bands, SORT_NUMERIC );
			}
			$rate['options']['quantity']['rates'] = $new_quantity_bands;

			// Deal with Per-product Pricing config
			if ( isset ( $_POST['missingprices'] ) ) {
				$rate['options']['perproduct']['missingprices'] = $_POST['missingprices'];
			}
			// Save settings
			$settings = &$this->settings;
			if ( $adding )
				$settings['rates'][] = $rate;
			else
				$settings['rates'][$_POST['rate_id']] = $rate;

			update_option( 'woo_ps', $settings );
			echo '<div id="message" class="updated"><p>' . __( 'Settings updated.', 'woo_ps' ) . '</p></div>';
		}

		function admin_page() {
			if ( ! isset ( $_REQUEST['pre-action'] ) )
				$_REQUEST['pre-action'] = '';
			if ( ! isset ( $_REQUEST['action'] ) )
				$_REQUEST['action'] = '';
			switch ( $_REQUEST['pre-action'] ) {
				case 'edit_rate':
				case 'add_rate':
					$this->edit_rate();
					break;
				case 'delete_rate':
					$this->delete_rate();
					break;
				case 'edit_override':
				case 'add_override':
					$this->edit_override();
					break;
				case 'delete_override':
					$this->delete_override();
					break;
			}

			switch ( $_REQUEST['action'] ) {
				case 'add_rate':
					include ( 'html/edit_rate.php' );
					break;
				case 'edit_rate':
					include ( 'html/edit_rate.php' );
					break;
				case 'delete_rate':
					include ( 'html/delete_rate.php' );
					break;
				case 'add_override':
					include ( 'html/edit_override.php' );
					break;
				case 'edit_override':
					include ( 'html/edit_override.php' );
					break;
				case 'delete_override':
					include ( 'html/delete_override.php' );
					break;
				default:
					include ( 'html/admin_home.php' );
					break;
			}
		}
	}
}