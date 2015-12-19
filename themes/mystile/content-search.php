<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * The default template for displaying content
 */

	global $woo_options;
  
?>

	<article <?php post_class('post'); ?>> <?php /* Adding 'post' to make styles consistent. */ ?>
	
	    <?php 
	    	if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] != 'content' ) { 
	    		woo_image( 'width=100&height=100&class=thumbnail alignleft' ); 
	    	} 
	    ?>
	    
		<header>
			<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<?php //woo_post_meta(); ?>
		</header>

		<section class="entry">
			<?php the_excerpt(); ?>
		</section>
		<?php 
			if ($post->post_type == 'post') {
				share_this_buttons();
			}
		?>

	</article><!-- /.post -->