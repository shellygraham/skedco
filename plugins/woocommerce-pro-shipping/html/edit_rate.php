<?php

    global $woo_ps_pro_shipping;

?>


<div class="wrap">
<h2><?php _e("Pro Shipping",'woo_ps'); ?></h2>
<form action="<?php echo $this->admin_url; ?>" method="POST">
<?php
    if ( isset ( $_GET['rate_id'] ) ) {
        $rate = $this->get_rate($_GET['rate_id']);
    } elseif ( isset ( $_GET['clone_rate_id'] ) ) {
        $rate = $this->get_rate($_GET['clone_rate_id']);
    } else {
        $rate = FALSE;
    }

    if ( $rate ) { ?>
            <input type="hidden" name="rate_id" value="<?php esc_attr_e ( $_GET['rate_id'] ); ?>">
    <?php } ?>
            <input type="hidden" name="pre-action" value="edit_rate">

<h3><?php _e ( 'Rate Settings', 'woo_ps' ); ?></h3>
<p>
    <label for="admin_facing_name"><?php _e ( 'Your reference', 'woo_ps' ); ?></label><br>
    <input placeholder="<?php _e('Description used to refer to the shipping rate internally', 'woo_ps'); ?>" type="text" name="admin_facing_name" size="60" value="<?php if ( isset ( $rate['admin_facing_name'] ) ) echo esc_attr($rate['admin_facing_name']); ?><?php if ( isset ( $_GET['clone_rate_id'] ) ) echo esc_attr ( __( ' (Copy)', 'woo_ps' ) ); ?>">
</p>
<p>
    <label for="user_facing_name"><?php _e ( 'Customer facing description', 'woo_ps' ); ?></label><br>
    <input placeholder="<?php _e('Description shown to the customer during checkout', 'woo_ps'); ?>" type="text" name="user_facing_name" size="60" value="<?php if ( isset ( $rate['user_facing_name'] ) ) echo esc_attr($rate['user_facing_name']); ?><?php if ( isset ( $_GET['clone_rate_id'] ) ) echo esc_attr ( __( ' (Copy)', 'woo_ps' ) ); ?>">
</p>
<h3><?php _e ( 'Availability', 'woo_ps' ); ?></h3>
<p>
    <label for="availability"><?php _e ( 'Rate available for shipping to', 'woo_ps' ); ?></label><br>
    <select name="availability" id="availability">
        <option value="all" <?php if ( isset ( $rate['availability'] ) && $rate['availability'] == 'all' ) echo "selected=\"on\""; ?>>Everywhere</option>
        <option value="countries" <?php if ( isset ( $rate['availability'] ) && $rate['availability'] == 'countries' ) echo "selected=\"on\""; ?>>Selected countries only</option>
        <option value="states" <?php if ( isset ( $rate['availability'] ) && $rate['availability'] == 'states' ) echo "selected=\"on\""; ?>>Selected states only</option>
    </select>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            if ( jQuery('#availability').val() == 'countries' ) {
                jQuery('#woo_ps_country_list').slideDown();
            } else if ( jQuery('#availability').val() == 'states' ) {
                jQuery('#woo_ps_state_list').slideDown();
            }
            jQuery('#availability').change(function(){
                    jQuery('#woo_ps_country_list').slideUp();
                    jQuery('#woo_ps_state_list').slideUp();
                    if ( jQuery('#availability').val() == 'countries') {
                        jQuery('#woo_ps_country_list').slideDown();
                    } else if ( jQuery('#availability').val() == 'states') {
                        jQuery('#woo_ps_state_list').slideDown();
                    }
            });
        });
    </script>
    <div id="woo_ps_country_list" style="display: none;">
        <?php $this->list_countries ( isset ( $rate['countries'] ) ? $rate['countries'] : FALSE); ?>
    </div>
    <div id="woo_ps_state_list" style="display: none;">
        <?php $this->list_states ( isset ( $rate['states'] ) ? $rate['states'] : FALSE); ?>
    </div>
</p>
<h3><?php _e ( 'Prices', 'woo_ps' ); ?></h3>
<p>
<?php _e ( 'Prices are based on ', 'woo_ps' ); ?>
    <select name="type" id="type">
        <option value="flat" <?php if ( isset ( $rate['type'] ) && $rate['type'] == 'flat' ) echo "selected=\"on\""; ?>><?php _e ( 'Flat rate', 'woo_ps'); ?></option>
        <option value="weight" <?php if ( isset ( $rate['type'] ) && $rate['type'] == 'weight' ) echo "selected=\"on\""; ?>><?php _e ('Weight', 'woo_ps'); ?></option>
        <option value="value" <?php if ( isset ( $rate['type'] ) && $rate['type'] == 'value' ) echo "selected=\"on\""; ?>><?php _e ('Order value', 'woo_ps'); ?></option>
        <option value="quantity" <?php if ( isset ( $rate['type'] ) && $rate['type'] == 'quantity' ) echo "selected=\"on\""; ?>><?php _e ('Number of items', 'woo_ps'); ?></option>
        <option value="perproduct" <?php if ( isset ( $rate['type'] ) && $rate['type'] == 'perproduct' ) echo "selected=\"on\""; ?>><?php _e ('Prices set per-product', 'woo_ps'); ?></option>
    </select>
    <span id="quantity_options_span" style="display: none;">
        <?php
            if ( isset ( $rate['options']['quantity']['exclude_no_shipping'] ) )
                $exclude_no_shipping = $rate['options']['quantity']['exclude_no_shipping'];
            else
                $exclude_no_shipping = TRUE;
        ?>
        <br>Which items to count:<br/>
        <input type="radio" name="qty_exclude_no_shipping" value="yes" <?php echo $exclude_no_shipping ? 'checked' : ''; ?> >Only items where shipping is not disregarded<br>
        <input type="radio" name="qty_exclude_no_shipping" value="no" <?php echo ! $exclude_no_shipping ? 'checked' : ''; ?> >All items<br>
    </span>
    <span id="weight_options_span" style="display: none;"> in
        <?php
            if ( isset ( $rate['options']['weight']['units'] ) )
                $weight_units = $rate['options']['weight']['units'];
            else
                $weight_units = get_option('woocommerce_weight_unit') ? get_option('woocommerce_weight_unit') :'kg';

            if ( isset ( $rate['options']['weight']['calc_type'] ) )
                $calc_type = $rate['options']['weight']['calc_type'];
            else
                $calc_type = 'total';
        ?>
        <select name="weight_units" id="weight_units">
            <option value="lbs" <?php if ( $weight_units == 'lbs' ) echo "selected=\"on\""; ?>><?php _e ( 'pounds (lbs)', 'woo_ps' ); ?></option>
            <option value="kg" <?php if ( $weight_units == 'kg' ) echo "selected=\"on\""; ?>><?php _e ( 'kilograms (kg)', 'woo_ps' ); ?></option>
            <option value="g" <?php if ( $weight_units == 'g' ) echo "selected=\"on\""; ?>><?php _e ( 'grams (g)', 'woo_ps' ); ?></option>
            <option value="oz" <?php if ( $weight_units == 'oz' ) echo "selected=\"on\""; ?>><?php _e ( 'ounces (oz)', 'woo_ps' ); ?></option>
        </select>
        <!-- <br/>Prices based on:<br/> -->
        <input type="hidden" name="calc_type" value="total" <?php echo $calc_type == 'total' ? 'checked' : ''; ?> >
        <!-- Single quote for total cart weight<br>
        <input type="radio" name="calc_type" value="items" <?php echo $calc_type == 'items' ? 'checked' : ''; ?> >Sum of quotes for individual items<br>
        <input type="radio" name="calc_type" value="consolidateditems" <?php echo $calc_type == 'consolidateditems' ? 'checked' : ''; ?> >Sum of quotes for consolidated items<br> -->
    </span>
    <div id="woo_ps_flat" style="display: none;">
        <label for "flat_rate"><?php _e ( 'Price: ', 'woo_ps' ); ?></label>
        <?php
            echo $this->wrap_content_with_currency('<input type="text" name="flat_rate" value = "'.(isset ( $rate['options']['flat']['rate'] ) ? esc_attr ( $rate['options']['flat']['rate'] ) : "").'">');
        ?>

    </div>
    <div id="woo_ps_weight" style="display: none;">
        <div id="woo_ps_weight_layers">
        <?php

            if ( isset ( $rate['options']['weight']['rates'] ) )
                $weight_rates = $rate['options']['weight']['rates'];
            else
                $weight_rates = Array();

            if ( count ( $weight_rates ) ) {

                $weights = array_keys ( $weight_rates ) ;

                foreach ( $weights as $weight ) {

                    echo '<div class="woo_ps_weight_layer">';
                    _e ( 'If weight is equal to, or over: ', 'woo_ps' );;
                    echo '<input type="text" name="weights[]" style="width: 50px;" size="8" value="'.esc_attr($weight).'">';
                    $this->show_weight_units ($weight_units);
                    _e ( 'charge ', 'woo_ps' );
                    echo $this->wrap_content_with_currency ('<input type="text" name="weight_rates[]" style="width: 50px;" size="8" value="'.esc_attr( $weight_rates[$weight] ).'"');
                    echo '<a class="woo_ps_weight_layer_delete">('.__('delete', 'woo_ps').')</a>';
                    echo '<br/>';
                    echo '</div>';

                }

            } else {

                echo '<div class="woo_ps_weight_layer">';
                _e ( 'If weight is equal to, or over: ', 'woo_ps' );
                echo '<input type="text" name="weights[]" style="width: 50px;" size="8" value="0">';
                $this->show_weight_units ($weight_units);
                _e ( 'charge ', 'woo_ps' );
                echo $this->wrap_content_with_currency('<input type="text" name="weight_rates[]" style="width: 50px;" size="8">');
                echo '<a href="#" class="woo_ps_weight_layer_delete">('.__('delete', 'woo_ps').')</a>';
                echo '<br/>';
                echo '</div>';

            }

        echo "</div>";
        echo '<br/>';
        echo '<a id="woo_ps_weight_newlayer">New Layer</a>';
        ?>
        <script type="text/javascript">
            jQuery(document).on('click', '.woo_ps_weight_layer_delete', function() {
                jQuery(this).parents(".woo_ps_weight_layer").each(function(){
                    jQuery(this).html("");
                    } );
                } );
            jQuery("#weight_units").change ( function() {
                    jQuery(".weight_unit_desc").each(function () {
                        var selected_value = jQuery("#weight_units").val();
                        if ( selected_value == "lbs" )
                            desc = "<?php _e('lbs','woo_ps'); ?>";
                        else if ( selected_value == "kg" )
                            desc = "<?php _e('kg','woo_ps'); ?>";
                        else if ( selected_value == "g" )
                        	desc = "<?php _e('g','woo_ps'); ?>";
                        else if ( selected_value == "oz" )
                        	desc = "<?php _e('oz','woo_ps'); ?>";

                        jQuery(this).html(desc) ;
                    });
                });
            jQuery("#woo_ps_weight_newlayer").click(function(event){
                jQuery("#woo_ps_weight_layers").append("<div class=\"woo_ps_weight_layer\"><?php _e ( 'If weight is equal to, or over: ', 'woo_ps' ); ?><input type=\"text\" name=\"weights[]\" style=\"width: 50px;\" size=\"8\"><?php
                    $this->show_weight_units ( $weight_units, TRUE );
                    _e ( 'charge ', 'woo_ps' );
                    echo $this->wrap_content_with_currency('<input type=\"text\" name=\"weight_rates[]\" style=\"width: 50px;\" size=\"8\">', true);
                    echo '<a href=\"#\" class=\"woo_ps_weight_layer_delete\">('.__('delete', 'woo_ps').')</a>'; echo '<br/></div>';?>");
                });
        </script>
    </div>
    <div id="woo_ps_value" style="display: none;">
        <div id="woo_ps_value_layers">
        <?php

            if ( isset ( $rate['options']['value']['rates'] ) )
                $value_rates = $rate['options']['value']['rates'];
            else
                $value_rates = Array();

            if ( count ( $value_rates ) ) {

                $values = array_keys ( $value_rates ) ;

                foreach ( $values as $value ) {

                    echo '<div class="woo_ps_value_layer">';
                    _e ( 'If cart value is equal to, or over: ', 'woo_ps' );;
                    echo $this->wrap_content_with_currency('<input type="text" name="values[]" style="width: 50px;" size="8" value="'.esc_attr($value).'">');
                    echo ', ';
                    _e ( 'charge ', 'woo_ps' );
                    echo $this->wrap_content_with_currency('<input type="text" name="value_rates[]" style="width: 50px;" size="8" value="'.esc_attr( $value_rates[$value] ).'">');
                    echo '<a class="woo_ps_value_layer_delete">('.__('delete', 'woo_ps').')</a>';
                    echo '<br/></div>';

                }

            } else {

                echo '<div class="woo_ps_value_layer">';
                _e ( 'If cart value is equal to, or over: ', 'woo_ps' );
                echo $this->wrap_content_with_currency('<input type="text" name="values[]" style="width: 50px;" size="8" value="0">');
                echo ', ';
                _e ( 'charge ', 'woo_ps' );
                echo $this->wrap_content_with_currency('<input type="text" name="value_rates[]" style="width: 50px;" size="8">');
                echo '<a class="woo_ps_value_layer_delete">('.__('delete', 'woo_ps').')</a>';
                echo '<br/></div>';

            }

        echo "</div>";
        echo '<br/>';
        echo '<a id="woo_ps_value_newlayer">New Layer</a>';
        ?>
        <script type="text/javascript">
            jQuery(document).on('click','.woo_ps_value_layer_delete', function() {
                jQuery(this).parents(".woo_ps_value_layer").each(function(){
                    jQuery(this).html("");
                    } );
                } );
            jQuery("#woo_ps_value_newlayer").click(function(event){
                jQuery("#woo_ps_value_layers").append("<div class=\"woo_ps_value_layer\"><?php _e ( 'If cart value is equal to, or over: ', 'woo_ps' ); echo $this->wrap_content_with_currency('<input type=\"text\" name=\"values[]\" style=\"width: 50px;\" size=\"8\">', true ); echo ', '; _e ( 'charge ', 'woo_ps' );
                    echo $this->wrap_content_with_currency('<input type=\"text\" name=\"value_rates[]\" style=\"width: 50px;\" size=\"8\">', true ); echo '<a class=\"woo_ps_value_layer_delete\">('.__('delete', 'woo_ps').')</a>'; echo '<br/></div>';?>");
                });
        </script>
    </div>
    <div id="woo_ps_quantity" style="display: none;">
        <div id="woo_ps_quantity_layers">
        <?php

            if ( isset ( $rate['options']['quantity']['rates'] ) )
                $quantity_rates = $rate['options']['quantity']['rates'];
            else
                $quantity_rates = Array();

            if ( count ( $quantity_rates ) ) {

                $quantities = array_keys ( $quantity_rates ) ;

                foreach ( $quantities as $qty ) {

                    echo '<div class="woo_ps_quantity_layer">';
                    _e ( 'If number of items is equal to, or over: ', 'woo_ps' );;
                    echo '<input type="text" name="quantities[]" style="width: 50px;" size="8" value="'.esc_attr($qty).'">';
                    echo ', ';
                    _e ( 'charge ', 'woo_ps' );
                    echo $this->wrap_content_with_currency('<input type="text" name="quantity_rates[]" style="width: 50px;" size="8" value="'.esc_attr( $quantity_rates[$qty] ).'">');
                    echo '<a class="woo_ps_quantity_layer_delete">('.__('delete', 'woo_ps').')</a>';
                    echo '<br/></div>';

                }

            } else {

                echo '<div class="woo_ps_quantity_layer">';
                _e ( 'If number of items is equal to, or over: ', 'woo_ps' );
                echo '<input type="text" name="quantities[]" style="width: 50px;" size="8" value="0">';
                echo ', ';
                _e ( 'charge ', 'woo_ps' );
                echo $this->wrap_content_with_currency('<input type="text" name="quantity_rates[]" style="width: 50px;" size="8">');
                echo '<a class="woo_ps_quantity_layer_delete">('.__('delete', 'woo_ps').')</a>';
                echo '<br/></div>';

            }

        echo "</div>";
        echo '<br/>';
        echo '<a id="woo_ps_quantity_newlayer">New Layer</a>';
        ?>
        <script type="text/javascript">
            jQuery(document).on ( 'click', '.woo_ps_quantity_layer_delete', function() {
                jQuery(this).parents(".woo_ps_quantity_layer").each(function(){
                    jQuery(this).html("");
                    } );
                } );
            jQuery("#woo_ps_quantity_newlayer").click(function(event){
                jQuery("#woo_ps_quantity_layers").append("<div class=\"woo_ps_quantity_layer\"><?php _e ( 'If number of items is equal to, or over: ', 'woo_ps' ); ?><input type=\"text\" name=\"quantities[]\" style=\"width: 50px;\" size=\"8\">, <?php  _e ( 'charge ', 'woo_ps' );
                    echo $this->wrap_content_with_currency('<input type=\"text\" name=\"quantity_rates[]\" style=\"width: 50px;\" size=\"8\">', true);
                    echo '<a class=\"woo_ps_quantity_layer_delete\">('.__('delete', 'woo_ps').')</a>'; echo '<br/></div>';?>");
                });
        </script>
    </div>
	<div id="woo_ps_perproduct" style="display: none;">
        <p><?php _e ( 'Click "Add Rate", then set your prices against each product.', 'woo_ps' ); ?></p>
        <p><?php _e ( "If no rate is configured for a product in the user's cart then ", 'woo_ps' );?>
        <select name="missingprices">
            <?php $missingprices = isset ( $rate['options']['perproduct']['missingprices'] ) ? $rate['options']['perproduct']['missingprices'] : 'noquote'; ?>
            <option value="zero" <?php if ( $missingprices == 'zero' ) echo "selected='selected'"; ?>><?php _e ( 'Charge that product at ', 'woo_ps' ); echo $this->wrap_content_with_currency('0.00'); ?></option>
            <option value="noquote" <?php if ( $missingprices == 'noquote' ) echo "selected='selected'"; ?>><?php _e ( "Don't return a price for that order", 'woo_ps' ); ?></option>
        </select></p>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            if ( jQuery('#type').val() == 'flat' ) {
                jQuery('#woo_ps_flat').slideDown();
            } else if ( jQuery('#type').val() == 'weight' ) {
                jQuery('#woo_ps_weight').slideDown();
                jQuery('#weight_options_span').fadeIn();
            } else if ( jQuery('#type').val() == 'value' ) {
                jQuery('#woo_ps_value').slideDown();
            } else if ( jQuery('#type').val() == 'quantity' ) {
                jQuery('#woo_ps_quantity').slideDown();
                jQuery('#quantity_options_span').fadeIn();
            } else if ( jQuery('#type').val() == 'perproduct' ) {
                jQuery('#woo_ps_perproduct').slideDown();
            }
            jQuery('#type').change(function(){
                    jQuery('#woo_ps_flat').slideUp();
                    jQuery('#woo_ps_weight').slideUp();
                    jQuery('#woo_ps_value').slideUp();
                    jQuery('#woo_ps_quantity').slideUp();
                    jQuery('#woo_ps_perproduct').slideUp();
                    jQuery('#weight_options_span').fadeOut();
                    jQuery('#quantity_options_span').fadeOut();
                    if (jQuery('#type').val() == 'flat') {
                        jQuery('#woo_ps_flat').slideDown();
                    } else if ( jQuery('#type').val() == 'weight') {
                        jQuery('#woo_ps_weight').slideDown();
                        jQuery('#weight_options_span').fadeIn();
                    } else if ( jQuery('#type').val() == 'value') {
                        jQuery('#woo_ps_value').slideDown();
                    } else if ( jQuery('#type').val() == 'quantity') {
                        jQuery('#woo_ps_quantity').slideDown();
                        jQuery('#quantity_options_span').fadeIn();
                    } else if ( jQuery('#type').val() == 'perproduct') {
                        jQuery('#woo_ps_perproduct').slideDown();
                    }
            });
        });
    </script>

<?php
    if ( ! $rate ) { ?>
        <input type="submit" value="<?php _e ( 'Add Rate', 'woo_ps' ); ?>">
    <?php } else { ?>
        <input type="submit" value="<?php _e ( 'Update Rate', 'woo_ps' ); ?>">
    <?php } ?>
</form>
</div>