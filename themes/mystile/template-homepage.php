<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Template Name: Home Page
 *
 * The blog page template displays the "Home Page." 
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
	
	$slides = get_children(array('post_parent' => 834,'order' => 'ASC','post_status' => 'publish'));
	$keys = array_keys($slides);
?>
    <!-- #content Starts -->
    
    <?php hero_index_page_style() ?>


    <div id="content" class="col-full">
    <style>
    	.index-page-hero#home-page {
    		background:url(<?php echo current(wp_get_attachment_image_src(get_post_thumbnail_id(471),'category-hero')) ?>) no-repeat bottom center;
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
    	<h1 class="stacked"><?php echo get_field('headline', 471); ?></h1>
    	<h2 class="stacked"><?php echo get_field('subhead', 471); ?></h2>
		<span>
    </div>
	<?php home_page_js() ?>
	
	
	<div class="twocol-one" id="industry-news">
	<!--<h3>Industry News</h3>-->
	
	<?php
		$p_id = 807;
		$featured_product = new WP_Query("post_type=product&p=$p_id&show_posts=1");
		while ( $featured_product->have_posts() ) :
			global $post;
			$featured_product->the_post(); 
			get_template_part('skedco', 'home-page-product');
		endwhile;
		/*
		$i = 1;
		$industry_news_query = new WP_Query("post_type=post&showposts=3&cat=53");
		while ( $industry_news_query->have_posts() ) : 
			$industry_news_query->the_post();
			if ($i == 1) {
				get_template_part('skedco', 'post-excerpt');
			} else {
				get_template_part('skedco', 'post-title');
			}
			$i++;
		endwhile;
		wp_reset_query();
		*/
	?>
    </div>
    <div class="twocol-one last" id="training-techniques">
    
	<h3>Featured Products</h3>
	<?php
		$woocommerce_loop['columns'] = 2;
    	$woocommerce_loop['grid'] = 'twocol-one';
    	$args=array(
			'post_type' => 'product',
			'showposts'=>4,
			'caller_get_posts'=>1,
			'meta_key' => '_featured',
			'meta_value' => 'yes',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$product_query = new WP_Query( $args );
		
		//woocommerce_product_loop_start();
		if ( $product_query->have_posts() ):
			while ( $product_query->have_posts() ) :
				$product_query->the_post();
				woocommerce_get_template_part( 'content', 'product' );
			endwhile;
		else:
			// Insert any content or load a template for no posts found.
		endif;
	
	?>
	<?php
		/*
		$i = 1;
		$training_techniques_news_query = new WP_Query("post_type=post&showposts=3&cat=54");
		while ( $training_techniques_news_query->have_posts() ) : 
			$training_techniques_news_query->the_post();
			if ($i == 1) {
				get_template_part('skedco', 'post-excerpt');
			} else {
				get_template_part('skedco', 'post-title');
			}
			$i++;
		endwhile;
		wp_reset_query();
		*/
	?>
    
    </div>
    
    
    
    
    
    
    
    
    
 
    
    
    
    
    
    
    
    <div class="twocol-one" id="rescue-equipment">
	<h3>Rescue Equipment</h3>
	<?php
		$i = 1;
		$rescue_equipment_query = new WP_Query("post_type=post&showposts=1&cat=52");
		while ( $rescue_equipment_query->have_posts() ) : 
			$rescue_equipment_query->the_post();
			if ($i == 1) {
				get_template_part('skedco', 'post-excerpt');
			} else {
				get_template_part('skedco', 'post-title');
			}
			$i++;
		endwhile;
		wp_reset_query();
	?>
    </div>
    <div class="twocol-one last" id="rescue-heroes">
    
	<h3>Our Forums</h3>
	<?php
		echo do_shortcode('[bbp-forum-index]');
	?>
    
    </div>
    
    
    


  
    
    
    
    
    
    
    <hr />
    











<h2>Recently Purchased:</h2>

    <?php
    	$woocommerce_loop['columns'] = 4;
    	$woocommerce_loop['grid'] = 'fourcol-one';
    	$args=array(
			'post_type' => 'product',
			'showposts' => 4,
			'offset' => 4,
			'caller_get_posts' => 1,
			'meta_key' => '_featured',
			'meta_value' => 'yes',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$product_query = new WP_Query( $args );
		
		//woocommerce_product_loop_start();
		if ( $product_query->have_posts() ):
			while ( $product_query->have_posts() ) :
				$product_query->the_post();
				woocommerce_get_template_part( 'content', 'product' );
			endwhile;
		else:
			// Insert any content or load a template for no posts found.
		endif;
		//woocommerce_product_loop_end();
		wp_reset_query();

    ?>







 <hr />
    
    <div class="col-full" id="ask-bud">
     	<?php
     		$ab = new recentForum;
     		//say($ab);
     		$ask_bud->headline     = $ab->display->forum->title;
			$ask_bud->subhead      = $ab->display->forum->tagline;
			$ask_bud->meta_tags    = get_field('meta_tags', 'category_'. $ask_bud->term_id);
			$ask_bud->button_text  = "Ask Bud now";
			$ask_bud->image        = "http://54.201.187.188/wordpress/wp-content/uploads/2014/01/ask-bud-fpo.png";
			$ask_bud->description  = "Do you have an unmet rescue need? Ideas for improving the Sked? Ask Bud about a product, try to stump him with a combat medic question, or just say hello."; 
     	?>
     	<div style="width:50%;">
    	<h3 class="stacked"><?php echo $ask_bud->headline ?><h3>
    	<h4 class="subhead orange"><?php echo $ask_bud->subhead ?></h4>
    	<p><?php echo $ask_bud->description ?><br /><br /><a href="<?php echo $ab->display->forum->url ?>" class="button2"><?php echo $ask_bud->button_text ?></a></p>
    	

    	
    	</div>
    </div>







    </div><!-- /#content -->    
		
<?php get_footer(); ?>