<?php
	$current_user = wp_get_current_user();
?>
<!-- sidebar -->
<aside class="sidebar" role="complementary">

	<?php //get_template_part('searchform'); ?>

	<div class="sidebar-widget">
		<?php if (is_user_logged_in()) { ?>
			<h3>My Account (<?php echo $current_user->display_name ?>)</h3>
			<p><a href="/my-account">Change Address</a> | <a href="/my-account">Check Your Order(s)</a> | <?php wp_loginout($_SERVER['REQUEST_URI']); ?></p>
		<?php } ?>
		
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
	</div>

	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
	</div>

</aside>
<!-- /sidebar -->
