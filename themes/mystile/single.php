<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Single Post Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a post ('post' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
	
/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */
	
	$settings = array(
					'thumb_single' => 'false', 
					'thumb_single_align' => 'alignright'
					);
					
	$settings = woo_get_dynamic_values( $settings );
?>
       
    <div id="content" class="col-full">
    	<div class="threecol-two">
    	
    	<?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>
    	
    	
    	<section class="post-content">

					
	                <header>
	                
		                <h1><?php the_title(); ?></h1>
		                
	                	<?php woo_post_meta(); ?>
	                	
	                </header>
	                
	                <section class="entry fix">
	                	
	                	<?php the_content_with_pic(); ?>
	                	<?php
	                		// PopArt Mod: 2014-01-27
	                		$author = get_user_meta($post->post_author);
	                		if ($author['description'][0] != '') {
	                			printf("<p><strong>About the Author</strong></p><p><em>%s</em></p>", $author['description'][0]);
	                		}
	                	?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
					</section>
													
				</section>
    	
    	
    	<nav id="post-entries" class="fix">
	            <div class="nav-prev fl"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ); ?></div>
	            <div class="nav-next fr"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ); ?></div>
	        </nav><!-- #post-entries -->
            <?php
            	// Determine wether or not to display comments here, based on "Theme Options".
            	if ( isset( $woo_options['woo_comments'] ) && in_array( $woo_options['woo_comments'], array( 'post', 'both' ) ) ) {
            		//comments_template();
            	}

				} // End WHILE Loop
			} else {
		?>
			<article <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
			</article><!-- .post -->             
       	<?php } ?> 
    	
    	
    	
    	
		</div>
		<div class="threecol-one last">
			<?php get_sidebar(); ?>
		</div>
    </div><!-- #content -->
		
<?php get_footer(); ?>