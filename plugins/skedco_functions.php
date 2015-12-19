<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/*
  Plugin Name: Skedco - Functions
  Description: All the helper functions needed for the Skedco site.
  Author: CJ Stritzel
  Version: 1.0
 */

function get_wp_date_translate($date, $format = 'n/j/Y'){
	$date = mktime(0, 0, 0, date("m", strtotime($date)), date("d", strtotime($date)), date("Y", strtotime($date)));
	return date($format, $date);
}

function wp_date_translate($date, $format = 'n/j/Y'){
	echo get_wp_date_translate($date, $format);
}

add_theme_support( 'woocommerce' );



register_sidebar( array(
    'name'         => __( 'Front Page Forum Holder' ),
    'id'           => 'fp-forum',
    'description'  => __( '' ),
    'before_title' => '<h1>',
    'after_title'  => '</h1>',
) );

// Capture content between "<sku>" tags and add links.
function process_sku($content) {
	$regexp = "<sku>(.*)<\/sku>";
	$replacement = '<a href="' . home_url() . '/?s=\\1">\\1</a>';
	$content = preg_replace("/$regexp/siU", $replacement, $content);
	return $content;
}
add_action('the_content', 'process_sku');

function get_skedco_random_hero_img() {
	global $wpdb;
	$q = 'select post_id from ' . $wpdb->postmeta . ' where meta_key = "random_image" and meta_value = 1 order by rand() limit 1';
	//$results = $wpdb->query($q);
	$img_id = $wpdb->get_var($q);
	$img = wp_get_attachment_url($img_id);
	$img = "/wp-content/uploads/2014/06/header_pattern.v1.jpg";
	$img = "/wp-content/uploads/2014/06/interior_header_ribbon.v2.jpg";
	return $img;
}

function skedco_random_hero_img() {
	echo get_skedco_random_hero_img();
}

function skedco_breadcrumb() {
	$links = explode("/",$_SERVER[REQUEST_URI]);
	$a = array('home');
	foreach($links as $_) {
		if ($_) {
			$a[] = $_;
		}
	}
	say($a);
}

// For the search redirect.
add_action('init', 'do_output_buffer');
function do_output_buffer() {
        ob_start();
}

// Removes woocommerce breadcrumb(s)
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

// Add admin styles
function custom_css() {
	echo '
	
	<style type="text/css">
		/* Removing columns on Admin "Products" page. */
		#wpseo-score,
		.wpseo-score,
		.column-wpseo-score, 
		#wpseo-title,
		.wpseo-title, 
		.column-wpseo-title, 
		#wpseo-metadesc, 
		.wpseo-metadesc,
		.column-wpseo-metadesc, 
		#wpseo-focuskw,
		.wpseo-focuskw,
		.column-wpseo-focuskw {
			display:none;
		}
	</style>

';
}

add_action('admin_head', 'custom_css');

/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function example_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'skedco_instructions_dashboard_widget',	// Widget slug.
		'Skedco Instructions Dashboard Widget',	// Title.
		'skedco_dashboard_widget_function' 		// Display function.
	);	
}
add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );

function msrp_text() {
	echo '
	<p>
		<strong>Note:</strong> For international orders, tax, duty and shipping will be applied to the U.S. MSRP by our International Distributors. 
		On selected military products, Skedco offers discount for active duty personnel. 
		Please <a href="mailto:skedco@skedco.com?subject=Request for Active Duty Discount">e-mail us</a> to receive a discount code to use at check out with your active Military e-mail address.
	</p>
';}

function get_transactional_email_text($html = 1) {
	$text = ($html != 1) ? "\n\nTo check the status of your order: visit https://www.skedco.com/my-account/ ." : "\n\nClick to <a href=\"https://www.skedco.com/my-account/\">check the status of your order</a>.";
	return $text;
}

function transactional_email_text($html = 1) {
	echo get_transactional_email_text($html);
}

//**Custom Gravatar**/
add_filter( 'avatar_defaults', 'bourncreative_custom_gravatar' );
function bourncreative_custom_gravatar ($avatar_defaults) {
	$myavatar = home_url() . '/wp-content/uploads/2014/07/logo-lightened.png';
	$avatar_defaults[$myavatar] = "Custom Gravatar";
	return $avatar_defaults;
}

function be_gravatar_filter($avatar, $id_or_email, $size, $default, $alt) {
	//if ($id_or_email == 5) return "BUD";
	if ($id_or_email == 34) return "<img src='/wp-content/themes/skedco/img/logo2.png' class='avatar avatar-" . $size . " photo' height='" . $size . "' width='" . $size . "' />";
	return $avatar;
}
add_filter('get_avatar', 'be_gravatar_filter', 10, 5);
			 
/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function skedco_dashboard_widget_function() {

	// Display whatever it is you want to show.
	?>
	
	
	
	
	<p>Notes and instructions for maintaining the new skedco.com</p>

<h2>PRODUCTS</h2>

<p>150 draft & pending products &mdash; either created by Andy, or products that were never for sale that were migrated from the old site 

<h3>Adding new products</h3>
<ol>
	<li>Go to Products
	<li>Click "Add Product"
	<li>Add Product Name to "Product Name" (Use "&amp;reg;" to implement the registered trademark sign &reg;)
	<li>Add the product description to the main copy well under the Product Name
	<li>Add the SKU in the "General" tab in "Product Data"
	<li>Add the SKU in the "General" tab in "Product Data"
	<li>Add the price for simple products (no variations/options to choose from) in the "General" tab in "Product Data"
	<li>Add the variations in the "Variations" tab in "Product Data" (i.e., steel buckles vs. upgraded with cobra buckles)
	<li>Add the main product image using the "Set product image" link (in the Product Image box under the categories and tags on the right hand side), and either select an existing image from the media library or upload a file
	<li>Add supporting gallery images using the "Add product gallery images" link (in the Product Gallery box under the image, categories, and tags on the right hand side), and either select an existing images from the media library or upload files
</ol>

<h3>To feature a product in a specific industry (F&R, HAZMAT, Military…):</h3>
<ol>
	<li>Go to Products
	<li>Click the product title or "Edit" under the product you want to feature to get to the "Edit Product" page 
	<li>Choose from the most used "Product Tags" that apply to product 
	<li>Click "Publish"
</ol>

<h3>To feature the product in a specific discipline (packs & bags, water rescue…):</h3> 
<ol>
	<li>Go to Products
	<li>Click the product title or "Edit" under the product you want to feature to get to the "Edit Product" page 
	<li>Mark the "Product Categories" items that apply to that product 
	<li>Click "Publish"
</ol>

<h3>To feature the product in a specific order on industry & discipline pages:</h3>
<ol>
	<li>Go to Products
	<li>Click the product title or "Edit" under the product you want to feature to get to the "Edit Product" page 
	<li>Go to the "Advanced" tab in "Product Data" 
	<li>Change "Menu Order" to 1-5 to feature the product higher on the page, or 7+ to move it down the page (default is #6) 
	<li>Click "Publish"
</ol>

<h3>Managing Product Reviews:</h3>
<ol>
	<li>All existing and pending product reviews are available in the "Comments" section of the left-hand WordPress Admin page
	    NOTE: In addition to product reviews, "Comments" is also where you manage comments on blog posts
	<li>The number of new/pending reviews will show up as a red number to the right of "Comments"
	<li>Inside the "Comments" section, click "Pending" to filter the comments to only those pending
	<li>Hover over the review to approve, unapprove,
	<li>Existing and pending product reviews are also at the very bottom of the "Edit Product" page
	<li>You can approve, reply, edit, delete, or mark these reviews as spam directly from here
</ol>

<hr />

<h2>FORUMS</h2>

<h2>General Information on the Forums</h2>
<ol>
	<li>The forums are comprised of threads, topics, and replies:
	<li>Threads: the "buckets" for discussion, only Skedco can start these. They include the Forum Rules, General Discussion, Ask Bud, and other discussion areas Skedco wants to promote
	<li>Topics: these are user-generated submissions that relate to the thread they're apart of
	<li>Comments: either Skedco- or user-generated submissions that correspond to a particular topic in a thread
</ol>

<h2>Creating, Responding, and Managing the Forums</h2>
<ol>
	<li>There are multiple Skedco WordPress admin accounts to allow for Skedco's management and interaction on the forums.
	<li>Employees should login with personal admin accounts to respond to topics or comments that require a more personal touch (i.e. Ask Bud, or a comment that calls for personal feedback instead of corporate feedback) 
	<li>Andy@Skedco, Bud@Skedco, John@Skedco, Simon@Skedco 
	<li>Employees should login with the Skedco admin account to create new threads or respond in the corporate voice
	<li>Skedco admin account:
</ol>

<h2>To create a thread or respond to a topic, login with either your personal WordPress Admin account, or the general Skedco Admin account</h2>
<ol>
	<li>Go to "Forums" to manage/add/remove threads
	<li>Go to "Topics" and click "New Topic" to add a topic to a thread as Skedco or as an individual Skedco admin
	<li>Go to "Replies" and click "New Reply" to add a reply to a topic as Skedco or as an individual Skedco amin
</ol>

<h2>Managing customer-submitted content</h2>
<ol>
	<li>Newly submitted threads will be "pending" by default. 
	<li>To add it to the live site:
	<li>Below "Forums" in the left-hand WordPress Admin panel, "Topics" and "Replies" will have red indicators if new content is pending review
	<li>Click "Topics" or "Replies"
	<li>Click "Pending" (instead of "All") to filter the entries
	<li>Click the entry title or "Edit" under the entry you want to review to get to the "Edit Topic/Reply" page 
	<li>For Topics, change the "Status" drop-down (in Topic Attributes) from "Pending" to "Open" 
	<li>For Replies, change the "Status" drop-down
	<li>Unless the entry is inappropriate or should not be published for any reason, Click "publish"
</ol>

<hr />

<h2>E-COMMERCE</h2>
<ol>
	<li>WooCommerce > Orders
	<li>Email sent to XX@skedco.com when an order is made
	<li>Update the order to "complete" once it has been shipped
	<li>Add shipping tracking # to the "Notes" section, with "Customer Note" selected and it will be sent to the customer once you save the update 
	
</ol>

<h2>Coupons</h2>
<ol>
	<li>Go to &mdash; WooCommerce > Settings > Coupons > Add New Coupon
	<li>Ex: fdic2014
	<li>Select whether you want a $-amount off the entire cart or product, or a specific % off the entire cart of product
	<li>In "Usage Restriction" you can specify the product it's applicable on, or not applicable on
	<li>In "Usage Limits" you can specify whether it's for 1-time or unlimited use, for 10 or fewer products, etc.
</ol>

<hr />


<h2>EMAILS</h2>
<ol>
	<li>Skedco receives email notifications when new content is added to "pending" in the Forums: forums@skedco.com
	<li>Skedco receives email notifications when people use the contact forms (dealers page & contact us): skedco@skedco.com
	<li>Customer gets an email when the order has been marked as "complete"
	<li>If tracking # is added as a note at the same time as the order is marked as "complete," email will contain both of those updates
	<li>If tracking # is added after the order is marked and saved as "complete," a second email will be sent to customer
	<li>When customers sign-up to receive e-mail updates
	<li>Review new sign-ups by going to "Forms"  > "Submissions to review"
	<li>When it's time to send a newsletter, you download all of the "Newsletter" submissions and upload to campaign monitor
</ol>

	
	
	
	
	
	
	
	
	
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* These functions make relevanssi and bbPress play nice together.                   */
/*-----------------------------------------------------------------------------------*/
add_filter('relevanssi_content_to_index', 'rlv_add_replies', 10, 2);
add_filter('relevanssi_excerpt_content', 'rlv_add_replies', 10, 2);
function rlv_add_replies($content, $post) {
	if ($post->post_type == 'topic') {
		$replies = get_posts(array('post_type' => 'reply', 'post_parent' => $post->ID, 'posts_per_page' => -1));
		if (is_array($replies)) {
			foreach ($replies as $reply) {
				$content .= " " . $reply->post_content . " ";
			}
		}
	}
	return $content;
}
 
add_filter('wp_insert_post', 'rlv_index_replies');
function rlv_index_replies($post_id) {
	$post = get_post($post_id);
	if ($post->post_type == 'reply') {
		relevanssi_index_doc($post->post_parent, $remove_first = true, $custom_fields = false, $bypassglobalpost = true);
	}
}

function remove_paragraph_tags($content) {
	$content = str_replace('<p>','',str_replace('</p>','',$content));
	return $content;
}

/*-----------------------------------------------------------------------------------*/
/* This removes the "Additional Information" tab from the Product Page.              */
/*-----------------------------------------------------------------------------------*/

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
 
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );  	// Remove the additional information tab
    return $tabs;
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

function popart_remove_all_but_lower_48($states) {
	foreach(array('AK','AA','AE','AP','AS','GU','MP','PR','UM','VI') as $out) {
		unset($states['US'][$out]);
	}
	return $states;
}
add_filter( 'woocommerce_states', 'popart_remove_all_but_lower_48', 11 );

// Adding the "Featured Image" to the content itself.
add_filter('the_content', function($content){
	global $post;
	$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	if ($url && $post->post_type == "post") {
		$img = '<img src="'.$url.'" alt="" title="" class="left" />';
		$content = preg_replace('/^<p.*?>/','<p>'.$img, $content, 1);
	}
	return $content;
});

// Helpers
function say($a, $txt = false) {
	$txt = ($txt) ? $txt : "Your Array" ;
	echo '<pre>' . $txt . ' - ';
	print_r($a);
	echo '</pre>';
}

function get_featured_image_url($post_id) {
	return wp_get_attachment_url(get_post_thumbnail_id($post_id));
}

function featured_image_url($post_id) {
	echo get_featured_image_url($post_id);
}

function get_single_nsn($post_id) {
	return current(get_the_terms( $post_id, 'pa_nsn' ))->name;
}

function single_nsn($post_id) {
	echo get_single_nsn($post_id);
}

function get_variable_nsn($post_id) {
	global $product, $wpdb;
	if ($product->children) {
		$q = 'select meta_value from wp_postmeta where post_id in (' . implode(',',$product->children) . ') and meta_key = "_nsn" and meta_value != ""';
		$results = $wpdb->get_col($q);
		return $results;
	} else {
		return false;
	}
}

function variable_nsn($post_id) {
	echo implode(', ',get_variable_nsn($post_id));
}
?>