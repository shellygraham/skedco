<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	<?php global $product; ?>
	
<?php

	// English -----------------
	// -------------------------
	//
	// If 'post_type' is 'product,' and the sku (or the 'nsn') matches the search query exactly, redirect to the product page.
	// Leaving off the parameter of 'is this a redirect from the old site.'
	//
	// If 'post_type' is 'post,' the 'get' parameter 'redirect' is there
	// AND the 'post_name' matches the search query exactly, redirect to the post.

	

	if ($post->post_type == "product") {
		//echo "is product and we have a search query";
		$q   = strtolower(get_search_query());
		$sku = strtolower($product->get_sku());
		$nsn = strtolower(get_single_nsn($post->ID));
		if ($q == $sku || $q == $nsn) {
			//echo "gonna redirect";
			wp_redirect(get_permalink( get_the_ID() ), 301 ); exit;
		}
	} else if ($post->post_type == 'post' && isset($_GET['redirect'])) {
		if (get_search_query() == $post->post_name) {
			//echo "gonna redirect";
			wp_redirect(get_permalink( get_the_ID() ), 301 ); exit;
		}
	}
?>
	
	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
		<!-- post thumbnail -->
		
		<div class="col-sm-2">
			<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php //the_post_thumbnail(array(120,120)); // Declare pixel size you need inside the array ?>
				<?php the_post_thumbnail('thumbnail', array('class' => 'scale-with-grid left')); ?>
			</a>
			<?php else: ?>
				<!--<img src="/wp-content/themes/skedco/img/logo2.png" />-->
			<?php endif; ?>
		</div>
		<!-- /post thumbnail -->

		<!-- post title -->
		<div class="col-sm-10">

		<h2 class="top-flush">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		<!-- /post title -->

		<!-- post details -->
		<span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
		<!--<span class="author"><?php _e( 'Published by', 'skedco' ); ?> <?php the_author_posts_link(); ?></span>-->
		<!--
		<span class="comments"><?php comments_popup_link( __( 'Leave your thoughts', 'skedco' ), __( '1 Comment', 'skedco' ), __( '% Comments', 'skedco' )); ?></span>
		-->
		<!-- /post details -->

		<?php if($post->post_type == "product") { ?>
			<div class="right">
				SKU: <?php echo $product->get_sku(); ?>
				<?php if (get_single_nsn($post->ID)) { ?>
				<br />NSN: <?php single_nsn($post->ID) ?>
				<?php } ?>
			</div>
			<br class="clear" />
		<?php } ?>

		<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>

		<?php //edit_post_link(); ?>
		</div>
		<p>&nbsp;</p>
		</div>
	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'skedco' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
