<?php
/*
  Plugin Name: Woocommerce - Custom Fields for Variations
  Description: Add custom values (NSN) to Product Variations
  Author: Remi Corson (http://www.remicorson.com/woocommerce-custom-fields-for-variations/)
  Version: 1.0
 */
 

//Display Fields
add_action( 'woocommerce_product_after_variable_attributes', 'variable_fields', 10, 2 );
//JS to add fields for new variations
add_action( 'woocommerce_product_after_variable_attributes_js', 'variable_fields_js' );
//Save variation fields
add_action( 'woocommerce_process_product_meta_variable', 'save_variable_fields', 10, 1 );
 
/**
 * Create new fields for variations
 *
*/
function variable_fields( $loop, $variation_data ) {
?>
	<tr>
		<td>
			<?php
			// Text Field
			woocommerce_wp_text_input( 
				array( 
					'id'          => '_nsn['.$loop.']', 
					'label'       => __( 'NSN Number', 'woocommerce' ), 
					'value'       => $variation_data['_nsn'][0]
				)
			);
			?>
		</td>
	</tr>
<?php
}
 
/**
 * Create new fields for new variations
 *
*/
function variable_fields_js() {
?>
	<tr>
		<td>
			<?php
			// Text Field
			woocommerce_wp_text_input( 
				array( 
					'id'          => '_nsn[ + loop + ]', 
					'label'       => __( 'NSN Number', 'woocommerce' ), 
					'value'       => $variation_data['_nsn'][0]
				)
			);
			?>
		</td>
	</tr>
<?php
}
 
/**
 * Save new fields for variations
 *
*/
function save_variable_fields( $post_id ) {
	if (isset( $_POST['variable_sku'] ) ) :
 
		$variable_sku          = $_POST['variable_sku'];
		$variable_post_id      = $_POST['variable_post_id'];
		
		// Text Field
		$_nsn = $_POST['_nsn'];
		for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_nsn[$i] ) ) {
				update_post_meta( $variation_id, '_nsn', stripslashes( $_nsn[$i] ) );
			}
		endfor;

	endif;
}
?>