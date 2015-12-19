<div class="wrap">
<h2><?php _e( 'Pro Shipping', 'woo_ps'); ?></h2>
<?php
	$rate = $this->get_rate($_GET['rate_id']);
	if ( ! $rate ) {
		wp_die ( __('Rate not found.', 'woo_ps' ) ) ;
	}
?>
<p><?php echo sprintf ( __( "You've asked to delete the rate '%s'", 'woo_ps' ), esc_html($rate['admin_facing_name']) ); ?>. <?php _e('Are you sure you want to do that - it <strong>cannot</strong> be undone?', 'woo_ps'); ?></p>
<p>
<form method="POST" action="<?php echo esc_url ( $this->admin_url ); ?>">
<a href="<?php echo esc_url ( $this->admin_url ); ?>" class="button"><?php _e('No, keep this rate', 'woo_ps'); ?></a>
	<input type="hidden" name="rate_id" value="<?php esc_attr_e($_GET['rate_id']); ?>">
	<input type="hidden" name="pre-action" value="delete_rate">
	<?php wp_nonce_field ( 'woo_ps_delete_rate' ); ?>
	<input type="submit" class="button-primary" value="<?php _e('Yes, delete this rate', 'woo_ps'); ?>">
</form>
</p>
</div>
