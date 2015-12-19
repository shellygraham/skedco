<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php get_header(); ?>
    
    <div id="content" class="col-full">
    	
    	<?php woo_main_before(); ?>
    	
		<section id="main" class="col-left"> 

		<?php if (have_posts()) : $count = 0; ?>
        
            <?php if (is_category()) { ?>
        	<header class="archive-header">
        		<h1><?php _e( 'Archive', 'woothemes' ); ?> / <?php single_cat_title( '', true ); ?></h1> 
        		<span class="archive-rss"><?php $cat_id = get_cat_ID( single_cat_title( '', false ) ); echo '<a href="' . get_category_feed_link( $cat_id, '' ) . '">' . __( 'RSS feed for this section', 'woothemes' ) . '</a>'; ?></span>
        	</header>        
        
            <?php } elseif (is_day()) { ?>
            <header class="archive-header">
            	<h1><?php _e( 'Archive', 'woothemes' ); ?> / <?php the_time( get_option( 'date_format' ) ); ?></h1>
            </header>

            <?php } elseif (is_month()) { ?>
            <header class="archive-header">
            	<h1><?php _e( 'Archive', 'woothemes' ); ?> / <?php the_time( 'F, Y' ); ?></h1>
            </header>

            <?php } elseif (is_year()) { ?>
            <header class="archive-header">
            	<h1><?php _e( 'Archive', 'woothemes' ); ?> / <?php the_time( 'Y' ); ?></h1>
            </header>

            <?php } elseif (is_author()) { ?>
            <header class="archive-header">
            	<h1><?php _e( 'Archive by Author', 'woothemes' ); ?></h1>
            </header>

            <?php } elseif (is_tag()) { ?>
            <header class="archive-header">
            	<h1><?php _e( 'Tag Archives:', 'woothemes' ); ?> <?php single_tag_title( '', true ); ?></h1>
            </header>
            
            <?php } ?>

        <h1>FAQ's</h1>
        <p>NOT SURE IF THIS NEEDS A DESCRIPTION, BUT HERE'S WHERE IT WOULD LIVE.</p>
        
	        <div class="fix"></div>
        
        	<?php woo_loop_before(); ?>
        	
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); $count++; ?>

				<h3><?php the_title() ?></h3>
				
				<p><?php echo $post->post_content ?></p>

			<?php endwhile; ?>
            
	        <?php else: ?>
	        
	            <article <?php post_class(); ?>>
	                <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
	            </article><!-- /.post -->
	        
	        <?php endif; ?>  
	        
	        <?php woo_loop_after(); ?>
    
			<?php woo_pagenav(); ?>
                
		</section><!-- /#main -->
		
		<?php woo_main_after(); ?>

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>