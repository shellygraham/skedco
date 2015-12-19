<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/*
Plugin Name: Skedco Redirects
Plugin URI: http://skedco.com/
Description: List of redirects for the Skedco site.
Author: Ozh (repurposed from the web)
Author URI: http://planetozh.com/
*/

add_action('admin_init', 'skedco_sampleoptions_init' );
add_action('admin_menu', 'skedco_sampleoptions_add_page');

// Init plugin options to white list our options
function skedco_sampleoptions_init(){
	register_setting( 'skedco_sampleoptions_options', 'skedco_sample', 'skedco_sampleoptions_validate' );
}

// Add menu page
function skedco_sampleoptions_add_page() {
	add_options_page('Skedco Redirects', 'Skedco Redirects', 'manage_options', 'skedco_sampleoptions', 'skedco_sampleoptions_do_page');
}

// Draw the menu page itself
function skedco_sampleoptions_do_page() {
	?>
	<div class="wrap">
		<h2>Skedco Redirects</h2>
		<p>Enter redirects separated by line and comma. Like so...</p>
		<p>
			<code>old-site-last-segment-of-url, where-to-go/on-new-site</code>
			<br /><code>old-site-last-segment-of-url, where-to-go/on-new-site</code>
		</p>

		<form method="post" action="options.php">
			<?php settings_fields('skedco_sampleoptions_options'); ?>
			<?php $options = get_option('skedco_sample'); ?>
			<table class="form-table">
				<tr valign="top"><th scope="row">Set Redirects</th>
					<td><textarea name="skedco_sample[pairs]" style="width:100%;min-height:350px;"><?php echo $options['pairs']; ?></textarea></td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
	<?php	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function skedco_sampleoptions_validate($input) {
	// Say our second option must be safe text with no HTML tags
	$input['pairs'] =  wp_filter_nohtml_kses($input['pairs']);
	return $input;
}
