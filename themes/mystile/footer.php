<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Footer Template
 *
 * Here we setup all logic and XHTML that is required for the footer section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */
	global $woo_options;
	global $current_user;
	get_currentuserinfo();
	$login_logout = (is_user_logged_in()) ? sprintf('<a href="%s/my-account/logout/">Log Out, %s</a>', home_url(),$current_user->display_name) : sprintf('<a href="%s/my-account/?back_to=%s">Log In</a>', home_url(),$_SERVER['REQUEST_URI']);

	echo '<div class="footer-wrap">';

	$total = 4;
	if ( isset( $woo_options['woo_footer_sidebars'] ) && ( $woo_options['woo_footer_sidebars'] != '' ) ) {
		$total = $woo_options['woo_footer_sidebars'];
	}

	if ( ( woo_active_sidebar( 'footer-1' ) ||
		   woo_active_sidebar( 'footer-2' ) ||
		   woo_active_sidebar( 'footer-3' ) ||
		   woo_active_sidebar( 'footer-4' ) ) && $total > 0 ) {

?>
	<?php woo_footer_before(); ?>
	
		<section id="footer-widgets" class="col-full col-<?php echo $total; ?> fix">
	
			<?php $i = 0; while ( $i < $total ) { $i++; ?>
				<?php if ( woo_active_sidebar( 'footer-' . $i ) ) { ?>
	
			<div class="block footer-widget-<?php echo $i; ?>">
	        	<?php woo_sidebar( 'footer-' . $i ); ?>
			</div>
	
		        <?php } ?>
			<?php } // End WHILE Loop ?>
	
		</section><!-- /#footer-widgets  -->
	<?php } // End IF Statement ?>
	

		<footer id="footer" class="col-full">
	
			<div class="twocol-one">
				<div class="threecol-one">
					<!--<img src="/wordpress/wp-content/uploads/2014/01/main-logo.png" id="footer-logo" />-->
					<img src="<?php echo home_url() ?>/wp-content/uploads/2014/04/skedco_logo400.png" id="footer-logo" />
					<!--<img src="/wordpress/wp-content/uploads/2014/03/skedco_logo.png" id="footer-logo" class="size-full" />-->
				</div>
				<div class="threecol-one">
				<ul>
					<li><?php echo $login_logout ?></li>
					<li><a href="<?php echo home_url() ?>/shop/">Products</a></li>
					<li><a href="<?php echo home_url() ?>/training/">Support</a></li>
					<li><a href="<?php echo home_url() ?>/rescue-line/">Blog</a></li>
					<li><a href="<?php echo home_url() ?>/forums/">Forum</a></li>
					<li><a href="<?php echo home_url() ?>/about/our-story/">Our Story</a></li>
					<li><a href="<?php echo home_url() ?>/">Contact</a></li>
				</ul>
				</div>
				<div class="threecol-one last">
				<ul>
					<li><a href="http://www.youtube.com/user/skedcoInc" id="footer-youtube" target="_blank">YouTube</a></li>
					<li><a href="https://plus.google.com/115546381465209422158/about" id="footer-googleplus" target="_blank">Google+</a></li>
					<li><a href="https://www.facebook.com/pages/Skedco/214181008646361" id="footer-facebook" target="_blank">Facebook</a></li>
				</ul>
				</div>
			</div>
			
			<div class="twocol-one last">
				<div id="signup-form">
					<?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 2 ); } ?>
				</div>
				
				<p>
					<small>
						<big><strong>Skedco Inc.</strong></big><br />
						10505 SW Manhassett Drive, Tualatin, OR, 97062<br />
						<strong><a href="tel:18007777533">1-800-777-SKED</a> / <a href="mailto:info@skedco.com">info@skedco.com</a></strong>
					</small>
				</p>
			</div>
		</footer><!-- /#footer  -->
		<div class="col-full" style="text-align:center;font-size:.85em;">
			&copy;Copyright 2014 Skedco Inc. All rights reserved. <a href="http://www.popart.com" target="_blank">A Pop Art Production</a>
			<br />
			<a href="<?php echo home_url('/about/privacy-policy/') ?>">Privacy Policy</a>
			|
			<a href="<?php echo home_url('/about/sitemap/') ?>">Site Map</a>
			<br />&nbsp;
			<br />&nbsp;
			<br />&nbsp;
		</div>
	</div><!-- / footer-wrap -->

</div><!-- /#wrapper -->
<?php wp_footer(); ?>
<?php woo_foot(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/skedco.js"></script>
</body>
</html>