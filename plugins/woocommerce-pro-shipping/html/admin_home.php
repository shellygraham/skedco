<div class="wrap">
<h2><?php _e("Pro Shipping",'woo_ps'); ?></h2>
<div id="woo-ps-rate-config">
<h3><?php _e ( 'Shipping Rates', 'woo_ps'); ?></h3>
<?php

	if ( isset ( $this->{'settings'}['rates'] ) && count ( $this->{'settings'}['rates'] ) ) {

		echo '<p>'.__ ( 'Choose a rate to configure it - or add a new rate below:', 'woo_ps' ).'</p>';
		echo "<dl>";
		foreach ( $this->{'settings'}['rates'] as $rate_id => $rate ) {

			echo "<dt><a href=\"".esc_url($this->admin_url . '&action=edit_rate&rate_id=' . esc_attr ( $rate_id ) )."\">";
			esc_html_e ( $rate['admin_facing_name'] );
			echo "</a></dt>";
			echo "<dd>";
			switch ( $rate['availability'] ) {
				case 'all':
					_e ( 'Available everywhere', 'woo_ps' );
					break;
				case 'countries':
					_e ( 'Available in selected countries only', 'woo_ps' );
					break;
				case 'states':
					_e ( 'Available in selected states only', 'woo_ps' );
					break;
			}
			echo ', ';
			switch ( $rate['type'] ) {
				case 'flat':
					_e ( 'flat rate price', 'woo_ps');
					break;
				case 'weight':
					_e ( 'weight based pricing', 'woo_ps');
					break;
				case 'value':
					_e ( 'order value based pricing', 'woo_ps');
					break;
				case 'quantity':
					_e ( 'price based on number of items', 'woo_ps');
					break;
				case 'perproduct':
					_e ( 'prices set per-product', 'woo_ps');
					break;
			}
			echo '.';
			echo " (<a href=\"" . $this->admin_url . '&action=edit_rate&clone_rate_id=' . esc_attr ( $rate_id ) . "\">copy</a>)";
			echo " (<a href=\"" . $this->admin_url . '&action=delete_rate&rate_id=' . esc_attr ( $rate_id ) . "\">delete</a>)";
			echo "</dd>";

		}
		echo "</dl>";

	} else {

		echo '<div class="error"><p>'.__ ( "You don't have any rates configured yet - add a new rate below.", 'woo_ps' ).'</p></div>';

	}

?>
<a href="<?php esc_attr_e ( $this->admin_url ); ?>&action=add_rate"><button class="secondary-button"><?php _e ( 'Add Rate', 'woo_ps' ); ?></button></a>
</div>
</div>