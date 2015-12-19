<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php 
/**
 * Sidebar Template
 *
 * If a `primary` widget area is active and has widgets, display the sidebar.
 *
 * @package WooFramework
 * @subpackage Template
 */
	global $woo_options;
	
	if ( isset( $woo_options['woo_layout'] ) && ( $woo_options['woo_layout'] != 'layout-full' ) && !isset( $woo_options['sidebar_override'] ) ) {

		// Now let's get Ask Bud for the sidebar...
		$ab = new recentForum;
		//say($ab);
		$_date = $ab->display->question->date;
?>	
	<aside id="sidebar" class="col-right">

		<div id="ask-bud-sidebar">
    		<h3 class="background-orange"><?php echo $ab->display->forum->title ?></h3>
    		<img src="/wordpress/wp-content/uploads/2014/04/bud_coffee.jpg" class="floatright border" style="width:100px" />
    		<big><?php echo $ab->display->forum->tagline ?></big>
    		<br /><small class="date"><?php echo $_date ?></small>
    		<br /><br />
    		<p>
    		 	<big class="orange">Q:</big>
    		 	<?php echo $ab->display->question->text ?>
    		</p>
    		<p>
    		 	<big class="orange">A:</big> 
    		 	<?php echo $ab->display->ask_bud->answer ?>
    		</p>
    		<p>
    			<big>Got a question for Bud? <a href="" class="orange">Submit it here</a>!</big>
    		</p>
		</div>

		<?php woo_sidebar_inside_before(); ?>
		<?php if ( woo_active_sidebar( 'primary' ) ) { ?>
			<div class="primary">
				<?php woo_sidebar( 'primary' );  ?>
			</div>        
		<?php } // End IF Statement ?>   
		<?php woo_sidebar_inside_after(); ?>
	
	</aside><!-- /#sidebar -->

<?php } else if ( isset( $woo_options['sidebar_override'] ) ) {?>

	<aside id="sidebar" class="col-right <?php echo $woo_options['sidebar_override'] ?>">
    	<div class="primary">
			<?php call_user_func('sidebar_' . $woo_options['sidebar_override']); ?>
		</div>        
	</aside><!-- /#sidebar -->

<?php } ?>