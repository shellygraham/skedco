<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php

/*-----------------------------------------------------------------------------------*/
/* Start WooThemes Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

// Define the theme-specific key to be sent to PressTrends.
define( 'WOO_PRESSTRENDS_THEMEKEY', 'zdmv5lp26tfbp7jcwiw51ix9sj389e712' );

// WooFramework init
require_once ( get_template_directory() . '/functions/admin-init.php' );

/*-----------------------------------------------------------------------------------*/
/* Load the theme-specific files, with support for overriding via a child theme.
/*-----------------------------------------------------------------------------------*/

$includes = array(
				'includes/theme-options.php', 			// Options panel settings and custom settings
				'includes/theme-functions.php', 		// Custom theme functions
				'includes/theme-actions.php', 			// Theme actions & user defined hooks
				'includes/theme-comments.php', 			// Custom comments/pingback loop
				'includes/theme-js.php', 				// Load JavaScript via wp_enqueue_script
				'includes/sidebar-init.php', 			// Initialize widgetized areas
				'includes/theme-widgets.php',			// Theme widgets
				'includes/theme-install.php',			// Theme installation
				'includes/theme-woocommerce.php'		// WooCommerce options
				);

// Allow child themes/plugins to add widgets to be loaded.
$includes = apply_filters( 'woo_includes', $includes );

foreach ( $includes as $i ) {
	locate_template( $i, true );
}

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/










/*-----------------------------------------------------------------------------------*/
/* Globals */
/*-----------------------------------------------------------------------------------*/

// For the search redirect.
add_action('init', 'do_output_buffer');
function do_output_buffer() {
        ob_start();
}



function get_cart_count() {
	global $woocommerce;
	$q = 0;
	foreach ($woocommerce->cart->cart_contents as $k => $v) {
		if (!isset($v['bundled_by'])) { $q = $q + $v['quantity']; }
	}
	return $q;
}

function cart_count() {
	echo get_cart_count();
}


/*-----------------------------------------------------------------------------------*/
/* Home Page */
/*-----------------------------------------------------------------------------------*/

function home_page_js() {
	$a = array();
	foreach (get_children(array('post_parent' => 834,'order' => 'ASC','post_status' => 'publish')) as $child) {
		$_slug = str_replace('-','',$child->post_name);
		$a[$_slug]['title'] = htmlentities($child->post_title);
		$a[$_slug]['slug'] = $_slug;
		$a[$_slug]['img'] = wp_get_attachment_image_src(get_post_thumbnail_id($child->ID),'category-hero');
		$a[$_slug]['img'] = $a[$_slug]['img'][0];
		foreach( get_fields($child->ID) as $k => $v ) {
			$a[$_slug][$k] = $v;
		}
	}
	echo '<script type="text/javascript">slides=' . json_encode($a) . '</script>';
	echo '<script type="text/javascript" src="' . get_template_directory_uri() . '/js/jquery.backgroundpos.js"></script>';
	echo '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>';
	//say($a);
	//echo '<pre>' . implode("\n", $d) . '</pre>';
}





/*-----------------------------------------------------------------------------------*/
/* Hero Shots at the top of pages */
/*-----------------------------------------------------------------------------------*/

function popart_the_cat_description() {
	global $wp_query;
	$cat 			   = $wp_query->get_queried_object();
	$cat->headline     = get_field('headline', 'product_cat_'. $cat->term_id);
	$cat->subhead      = get_field('subhead', 'product_cat_'. $cat->term_id);
	$cat->meta_tags    = get_field('meta_tags', 'product_cat_'. $cat->term_id);
	$cat->button_text  = get_field('button_text', 'product_cat_'. $cat->term_id);
	$cat->image        = wp_get_attachment_url( get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ) );
	// say($cat);
	// set "heroic" index page styles, leave the background here because of the vars.
	hero_index_page_style();
	?>
	
	<style>
		div.index-page-hero#<?php echo $cat->slug ?> {
			background:url(<?php echo $cat->image ?>) bottom center no-repeat;
			background-size:1064px auto !important;
		}
	</style>
	<div class="index-page-hero" id="<?php echo $cat->slug ?>">
		<span>
			<h1 class="stacked"><?php echo $cat->headline ?></h1>
			<h2 class="stacked"><?php echo $cat->subhead ?></h2>
			<!--<a href="" class="button2"><?php echo $cat->button_text ?></a>-->
		</span>
	</div>
	<p><?php echo $cat->description ?></p>
	
	<?php
}

function hero_index_page_style() {
	?>
	<!-- Only operative if you have the hero shot at the top. -->
	<style>
		body.home #content { margin-top:326px !important; } /* Home page hero has the menu on the bottom */
		body #content { margin-top:276px !important; }
		h1.page-title {display:none;}
		div.index-page-hero {
			position:absolute;
			top:0px;
			width:1064px;
			height:176px;
			padding-top:130px;
			border-bottom:1px solid #999;
		}
		div.index-page-hero span {
			display:block;
			padding-left:20px;
			width:65%;
			position:absolute;
			bottom:15px;
		}
		div.index-page-hero h1, div.index-page-hero h2 { 
			margin:0; 
			padding:0; 
			/*
			text-shadow: 1px 2px #fff;
			color:#ff8022 !important;
			*/
			/* text-shadow: 1px 2px #ff8022; */
			color:#fff;
			line-height:1;
		}
		body.home.page div.index-page-hero h1, body.home.page div.index-page-hero h2 {
			color:#333 !important;
		}
		/* User is logged in */
		body.logged-in .index-page-hero {
			top:32px;
		}
	</style>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Not sure that these are used */
/*-----------------------------------------------------------------------------------*/


function process_list( $txt, $id, $before = FALSE ) {
	if (!$txt) return false;
	$txt = preg_replace('/[\r\n]+/', '</li><li>', $txt);
	$display = $before . '<ul id="' . $id . '"><li>' . $txt . '</li></ul>';
	echo $display;
}


add_action( 'wp_head', 'popart_seo', 10 );
function popart_seo() {
	if (is_product_category()) {
		global $wp_query;
		$cat 			   = $wp_query->get_queried_object();
		$cat->headline     = get_field('headline', 'product_cat_'. $cat->term_id);
		$cat->subhead      = get_field('subhead', 'product_cat_'. $cat->term_id);
		$cat->meta_tags    = get_field('meta_tags', 'product_cat_'. $cat->term_id);
		echo '<meta name="description" content="' . $cat->headline . ' | ' . $cat->subhead . ' | ' . $cat->description . '">';
		echo '<meta name="keywords" content="' . $cat->meta_tags . '">';
	}
}


function popart_template_price() { global $product; ?>
	<div itemprop="offers" id="priceinfo" itemscope itemtype="http://schema.org/Offer">
		<p itemprop="price" class="price"><?php echo do_shortcode('[skedco_msrp]') ?> <?php echo $product->get_price_html(); ?></p>
		<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
		<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
	</div>
<?php }

function popart_bundled_products_list() {
echo "LIST WILL GO HERE";
}




function share_this_buttons() { ?>
<?php // requires "the_post()" to be set. ?>

<span class="st">
	<span class="st_twitter" st_title="<?php the_title(); ?>" st_url="<?php the_permalink(); ?>"></span>
	<span class="st_facebook" st_title="<?php the_title(); ?>" st_url="<?php the_permalink(); ?>"></span>
	<span class="st_email" st_title="<?php the_title(); ?>" st_url="<?php the_permalink(); ?>"></span>
	<span class="st_sharethis" st_title="<?php the_title(); ?>" st_url="<?php the_permalink(); ?>"></span>
</span>

<?php
}

function be_menu_extras($menu, $args) {
	if( 'primary-menu' !== $args->theme_location )
	return $menu;
	return $menu . '<li class="right"><form action="' . home_url() . '"><input type="text" placeholder="Search..." name="s" /><input type="submit" value="Go"></form></li>';
}
//add_filter('wp_nav_menu_items','be_menu_extras', 10, 2);

add_shortcode( 'faqs','faqs_func');
function faqs_func() {
	$faqs = get_posts(array('posts_per_page' => 5,'post_type'=>'faq'));
}


/*-----------------------------------------------------------------------------------*/
/* Image/Thumbnail Functions */
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	// additional image sizes
	// delete the next line if you do not need additional image sizes...
	add_image_size( 'category-hero',1063,350,true);
	add_image_size( 'small-test',10,10,true);
	add_image_size( 'square250',250,250,true);
	add_image_size( 'square350',350,350,true);
	add_image_size( 'single-post',400);
	add_image_size( 'excerpt',200);
}

add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );
function custom_image_sizes_choose( $sizes ) {
    $custom_sizes = array(
        'category-hero' => 'Hero Shot'
    );
    return array_merge( $sizes, $custom_sizes );
}

/*-----------------------------------------------------------------------------------*/
/* Post Functions */
/*-----------------------------------------------------------------------------------*/





// Post Functions
function get_the_content_with_pic() {
	if (!has_post_thumbnail()) return $content;
	$attr = array('class' => 'floatright featured');
	$pic = the_post_thumbnail( 'single-post', $attr );
	$content = preg_replace('~<p>(.*?)</p>~s', '<p>' . $pic . '\1</p>', $content, 1);
	return $content;	
}
function the_content_with_pic() {
	echo get_the_content_with_pic();
}
function insert_featured_image_excerpt($content){
	if (!has_post_thumbnail() || get_post_type( $post ) != 'post') return $content;
	$attr = array('class' => 'floatleft featured');
	$pic = the_post_thumbnail( 'excerpt', $attr );
	$content = preg_replace('~<p>(.*?)</p>~s', '<p>' . $pic . '\1</p>', $content, 1);
	return $content;
}
add_filter( 'the_excerpt', insert_featured_image_excerpt, 20 );

/* Some pages have different sidebars. */
function sidebar_search() {
	printf( _n( '<strong>1</strong> result', '<strong>%s</strong> results', $GLOBALS['wp_query']->post_count, 'your_textdomain' ) . ' for <strong>' . get_search_query() . '</strong>' , $GLOBALS['wp_query']->post_count );
}
function sidebar_contact() {
	$the_contact = setup_postdata(get_post(550)); /* So the form will work right out of the box. */
	echo '<h3 class="background-orange">' . get_the_title(550) . '</h3>';
	the_content();
}

function sidebar_ecommerce() {
	echo '<h3 class="background-orange">Skedco</h3>';
	echo '<p>Vivamus at ultrices velit, id pulvinar nisi. In vel posuere nibh. Nulla facilisi. Mauris laoreet vulputate dolor, eu ornare lectus venenatis ut. Vivamus pretium quis nunc at ornare.</p>';
	echo '<p>Vivamus at ultrices velit, id pulvinar nisi. In vel posuere nibh. Nulla facilisi. Mauris laoreet vulputate dolor, eu ornare lectus venenatis ut. Vivamus pretium quis nunc at ornare.</p>';
}

// Generic helpers


function list_start($type = 'ul', $class = FALSE, $id = FALSE) {
	echo get_list_start($type, $class, $id);
}

function get_list_start($type = 'ul', $class = FALSE, $id = FALSE) {
	return sprintf('<%s class="%s" id="%s" style="list-style-type:none;">', $type, $class, $id);
}

function list_end($type='ul') {
	echo get_list_end($type);
}

function get_list_end($type='ul') {
	return "</$type>";
}

class ProductList {
	
	
	function __construct($type = 'product_cat', $term = '', $n = 4, $post_not_in = array() ) {
		
		$args = array(
			$type => $term,
			'post_type' => 'product',
			'showposts' => ($n + count($post_not_in)),
			'caller_get_posts' => 1,
			'post__not_in' => $post_not_in
		);
		$products_q = new WP_Query($args);
		$args['meta_key'] = '_featured';
		$args['meta_value'] = 'yes';
		$featured_products_q = new WP_Query($args);
		$products =	array_slice(
						array_unique(
							array_merge((array)$featured_products_q->posts, (array)$products_q->posts) 
						, SORT_REGULAR)
					,0,$n);
		$this->products = $products;
		$this->ids      = array_map("get_ids", $this->products);
		$this->not_in   = $post_not_in;
	}

}
// Helper map function
function get_ids($p) {return $p->ID;}


class forumList {
	function __construct() {
		$i = 0;
		$args = array( 'post_type' => array ( 'topic', 'reply' ), 'posts_per_page' => 10 );
		$this->debug->args = $args;
		$this->debug->posts = get_posts($args);
	}
}

class recentForum {
	function __construct($forum_id = FALSE) {
	
		global $wpdb;
		$forum_id = ($forum_id) ? $forum_id : 2021 ; // 2021 is the "Ask Bud" forum, consider it the default.
		$forum = get_post($forum_id);
		
		$this->topics_q = "select ID,post_title, post_parent,post_type, post_date from wp_posts where post_parent = $forum_id and post_type = 'topic'";
		$this->forum_results = $wpdb->get_results($this->topics_q);
		foreach ($this->forum_results as $_) {
			$this->parents[$_->ID] = $_;
		}
		$this->replies_q = sprintf("select * from wp_posts where post_parent in (%s) and post_type != 'revision' order by post_date DESC", implode(",",array_keys($this->parents)));
		$this->replies = $wpdb->get_results($this->replies_q);
		
		setup_postdata( $GLOBALS['post'] =& current($this->replies) );
		
		
		$this->display->forum->title = $forum->post_title;
		$this->display->forum->tagline = $forum->post_content;
		$this->display->forum->url = get_permalink($forum->ID);
		$this->display->question->text = $this->parents[current($this->replies)->post_parent]->post_title;
		$this->display->question->date = $this->parents[current($this->replies)->post_parent]->post_date;
		$this->display->question->url  = get_permalink($this->parents[current($this->replies)->post_parent]->ID);
		$this->display->answer->text = current($this->replies)->post_content;
		$this->display->answer->date = current($this->replies)->post_date;
		
		$_more = sprintf('<a href="%s" class="more-link">&hellip;</a>', $this->display->question->url);
		
		$this->display->answer->excerpt = str_replace('&hellip;',$_more, get_the_excerpt());
		
		$this->display->ask_bud->answer = end($this->replies)->post_content;
		
		
		
	}
}
function popart_add_image($content) {
	return '<p>' . woo_image( 'class=thumbnail alignright') . $content;
}
//add_filter('the_content','popart_add_image');

/*-----------------------------------------------------------------------------------*/
/* Disqus stuff. Mostly C/P from the docs/internet.                                  */
/*-----------------------------------------------------------------------------------*/

function disqus_categories($cat) {

	$cats = (object)array(
		"ask-bud" => 2986416,
		"forum" => 2986434,
		"product-reviews" => 2986435
	);
	//printf("\n\n<script>var disqus_category_id = '%s';</script>\n\n", $cats->$cat);
		
}

/*-----------------------------------------------------------------------------------*/
/* Extra WooCommerce stuff down here. Mostly C/P from the docs/internet.             */
/*-----------------------------------------------------------------------------------*/

/*
 * wc_remove_related_products
 * 
 * Clear the query arguments for related products so none show.
 * Add this code to your theme functions.php file.  
 */
function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10);

function popart_key_features_tab() {
	process_list(get_field('key_features'), 'key_features', '<h2>Key Features</h2>');
}

function popart_remove_all_but_lower_48($states) {
	foreach(array('AK','AA','AE','AP','AS','GU','MP','PR','UM','VI') as $out) {
		unset($states['US'][$out]);
	}
	return $states;
}
add_filter( 'woocommerce_states', 'popart_remove_all_but_lower_48', 11 );
 
add_filter('woocommerce_get_catalog_ordering_args', 'am_woocommerce_catalog_orderby');
function am_woocommerce_catalog_orderby( $args ) {
    $args['meta_key'] = '_featured';
    $args['orderby'] = 'meta_value';
    $args['order'] = 'desc'; 
    return $args;
}


/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/
?>