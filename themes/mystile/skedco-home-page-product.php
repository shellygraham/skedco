<?php
	$id = get_the_ID();
	$meta = get_post_meta($id);
?>
<!--
<h2><?php echo $meta['subhead'][0] ?></h2>
<p><?php echo $meta['front_page_text'][0] ?></p> 
-->
<img src="/wordpress/wp-content/uploads/2014/05/home_main_sked_ad.jpg" class="scale-with-grid" style="width:100%;" />
<p><?php the_excerpt() ?></p> 
<?php //say(get_post_meta($id)); ?>