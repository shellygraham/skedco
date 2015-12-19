<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Template Name: MicroSite Template (Individual)
 *
 * This is the template for the "Microsites."
 * It will use mostly the title. Let's see how this goes...
 */
 
 global $woocommerce;
 $woocommerce_loop['columns'] = 4;
 $woocommerce_loop['grid'] = 'fourcol-one';
?>

<?php while ( have_posts() ) : the_post(); ?>

<?php

	$the_blurb = get_the_content();
	$the_product_type = get_the_title();
	// Adding the custom fields to the $post object...
	foreach((object)get_fields(get_the_ID()) as $k => $v ) {
		$post->$k = $v;
	}
	$args = array( 
		'post_parent' => $post->ID,
		'numberposts' => '100',
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	foreach((object)get_children($args) as $k => $v ) {
		foreach((object)get_fields($k) as $key => $val ) {
			$v->$key = $val;
		}
		$tmp[] = $v;
	};
	$post->children = $tmp;
	$post->hero = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'category-hero');
	$post->tag_slug = $post->post_name;
	$post->tag_info = get_term_by( 'slug', $post->post_name, 'product_tag');
	$post->kw_option_key = sprintf('product_tag_%s_keywords', $post->tag_info->term_id);
	$post->discipline_kw = get_option($post->kw_option_key);
	//say($post);
?>

<?php get_header() ?>
	<?php hero_index_page_style(); ?>
	<style>
		.index-page-hero#<?php echo $post->post_name ?> {
			background:url(<?php echo $post->hero[0]; ?>) no-repeat bottom center;
			background-size:1063px auto;
		}
	</style>
    <div id="content" class="col-full"><!-- #content Starts -->
		<div class="index-page-hero" id="<?php echo $post->post_name ?>">
			<span>
			<h1 class="stacked"><?php echo $post->headline ?></h1>
			<h2 class="stacked"><?php echo $post->subhead ?></h2>
			</span>
		</div>

		
<?php endwhile; ?>

		<?php
    		// 1) Get four "post_name" tagged products.
    		$args = array(
    			'product_tag' => $post->post_name,
    			'post_type' => 'product',
    			'showposts' => 4,
    			'caller_get_posts' => 1
    		);
    		$products_q = new WP_Query($args);

    		// 2) Get four "post_name" tagged products that are featured.
    		$args['meta_key'] = '_featured';
    		$args['meta_value'] = 'yes';
    		$featured_products_q = new WP_Query($args);

    		// 3) Combine the two arrays, strip out duplicates and trim the resulting array to four elements.
    		$products =	array_slice(
    						array_unique(
    							array_merge((array)$featured_products_q->posts, (array)$products_q->posts) 
    						, SORT_REGULAR)
    					,0,4);

			printf("<h2>Featured Skedco&trade; %s Products</h2>",$the_product_type);
			printf("<p>%s</p>",$the_blurb);
			// woocommerce_product_loop_start();
			foreach($products as $product) {
				setup_postdata( $GLOBALS['post'] =& $product );
				woocommerce_get_template_part( 'content', 'product' );
			}
			// woocommerce_product_loop_end();
			wp_reset_query(); // gets the global post object back.
    	?>


		<hr />
		
		
		<?php
    		$args = array(
    			'tag' => $post->post_name, 
    			'post_type' => 'post',
    			'showposts'=> 6,
    			'caller_get_posts'=>1
    		);
    		$posts_query = new WP_Query($args);
    		$i = 1;
    		if ( $posts_query->have_posts() ):
    			printf("<h2>Recent %s Articles</h2>",$the_product_type);
    			list_start('ul','products', 'hp-posts');
				while ( $posts_query->have_posts() ) :
					$last = ($i % 2 == 0) ? " last" : "" ;
					$posts_query->the_post();
					get_template_part('skedco', 'post-small');
					$i++;
				endwhile;
				list_end('ul');
			else:
				// Insert any content or load a template for no posts found.
			endif;
    	?>

	</div><!-- /#content -->   
<?php get_footer(); ?>