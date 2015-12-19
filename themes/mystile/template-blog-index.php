<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Template Name: Blog Index Page
 *
 * The blog page template displays the "Rescue Wire" home page. 
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options;
 get_header();
 
/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */
	
	$settings = array(
					'thumb_w' => 787, 
					'thumb_h' => 300, 
					'thumb_align' => 'alignleft'
					);
					
	$settings = woo_get_dynamic_values( $settings );

	//say($slides[$keys[0]]);
?>
    <!-- #content Starts -->

    <div id="content" class="col-full">
    
    
    <?php hero_index_page_style() ?>
    
    <style>
    	.index-page-hero#home-page {
    		background:url(/wordpress/wp-content/uploads/2014/04/site_hero.jpg) no-repeat bottom center;
    		background-size:1063px auto !important;
    	}
    	.index-page-hero#home-page span h1,.index-page-hero#home-page span h2{
			/* 
			color:white !important;
			text-shadow: 2px 2px #999999; 
			*/
		}
		
    </style>
    
    <div class="index-page-hero" id="home-page">
    	<span>
    	<h1 class="stacked">The Rescue Line</h1>
    	<h2 class="stacked">News, techniques and gear talk – straight from the experts.</h2>
		<span>
    </div>
    
    
    
    
    <p>&nbsp;</p>
    
    
    <div class="banner-text" style="display:none;">
		<?php while ( have_posts() ) : the_post(); ?>
		<div class="threecol-two"><h1><?php the_title() ?></h1></div>
		<div class="threecol-one last"><small class="alignright shorter-line-height"><?php the_content() ?></small></div>
		<?php endwhile; ?>
		<br class="clear" />
	</div>
	
	

    <?php
    	$i = 1;
    	$args=array(
			'post_type' => 'post',
			'showposts' => 5,
			'caller_get_posts' => 1,
			'post_status' => 'publish',
			'category__not_in' => 29
		);
		$posts_query = new WP_Query( $args );
		while ( $posts_query->have_posts() ) : 
			$posts_query->the_post();
			
			//if ($i == 1) {
				//get_template_part('skedco', 'post-hero');
			//} else {
				if ($i == 1) {	echo '<div class="threecol-two">'; }
				get_template_part('skedco', 'post-excerpt');
				if ($i == count($posts_query->posts)) {	echo '</div><!--bikky-->'; }
			//}
		$i++;
		endwhile;
		wp_reset_query();
		
		
		//say($ab);
    ?>
    <div class="threecol-one last">
    	<?php get_sidebar(); ?>
    </div>

    </div><!-- /#content -->    
		
<?php get_footer(); ?>