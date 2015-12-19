<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/*
  Plugin Name: Skedco - Shortcodes
  Description: All the shortcodes needed for the Skedco site.
  Author: CJ Stritzel
  Version: 1.0
 */


$GLOBALS['_NOT_IN'] = array(); // Set array to avoid repeats on page.

function get_the_short_excerpt(){
	$excerpt = get_the_content();
	$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, 240);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
	$excerpt = $excerpt.'... <a href="'.get_permalink().'">View Article</a>';
	return $excerpt;
}

function get_the_short_title(){
	$maxLength = 45;
	$stitle = get_the_title();
	if (strlen($stitle)>$maxLength) {
		$stitle = substr($stitle, 0, $maxLength);
		$stitle = $stitle.'...';
	}
	return $stitle;
}

function content_first($post) {
	$_ = array();
	$_[] = sprintf('<a href="%s" title="%s" class="center-text"><img src="%s" class="chunk content first left" /></a>', get_permalink(),get_the_title(), wp_get_attachment_thumb_url( get_post_thumbnail_id($post->ID) , 'thumbnail' ));
	$_[] = sprintf('<h4><a href="%s">%s</a></h2>',get_permalink(),get_the_title());
	$_[] = sprintf('<small class="chunk content first">%s</small>', get_wp_date_translate(get_the_date()));
	$_[] = sprintf('<p>%s</p>', get_the_short_excerpt());
	$_[] = '<br class="clear hidden-xs" />';
	return "\n\t" . implode("\n\t", $_);
}

function content_abbreviated($p) {
	$_ = array();
	$_[] = '<span>';
	$_[] = sprintf('<small>%s</small>', get_wp_date_translate(get_the_date()));
	$_[] = sprintf('<a href="%s">%s</a>',get_permalink(),get_the_short_title());
	$_[] = '</span>';
	
	return "\n\t" . implode("\n\t", $_);
}

function skedco_content_func($atts) {
	global $post, $_NOT_IN;
	$atts = shortcode_atts( array(
        'type' => 'cat',
        'val' => '',
        'class' => 'col-sm-6',
        'n' => 5
    ), $atts );

	$i = 0;
	$args = array(
		'numberposts'   => $atts['n'], 
		'category_name' => $atts['val'],
		'post__not_in'  => $_NOT_IN
	);
	if ($atts['type'] == 'tag') {
		unset($args['category_name']);
		$args['tag'] = $atts['val'];
	}
	$taxonomy = ($atts['type'] == 'cat') ? 'category' : 'post_tag' ;
	$headline = get_term_by( 'slug' , $atts['val'] , $taxonomy);

	$posts      = get_posts( $args );

	$d          = array(sprintf('<div class="%s content-group %s">', $atts['class'], $atts['val']));
	$d[]        = sprintf('<h3><a href="/%s/%s">%s </a><small>&raquo;</small></h3>', $atts['type'], $headline->slug, $headline->name);
	foreach( $posts as $post ) {
		setup_postdata($post);
		$_NOT_IN[] = $post->ID;
		if ($i == 0) {
			$d[] = content_first($post);
		} else {
			$d[] = content_abbreviated($post);
		}
		$i++;
	}
	$d[] = '</div>';
	return "\n" . implode("\n",$d) . "\n\n";
}


function skedco_forum_func($atts) {
	extract( shortcode_atts( 
		array( 
			'type'  => '',
			'title' => '',
			'id'    => '',
			'class' => ''
		), 
		$atts 
	));
	ob_start();
	dynamic_sidebar('fp-forum');
	$sidebar_contents = ob_get_clean();
	return sprintf('<div class="%s content-group"><h3><a href="/forums/">Rescue Forums </a><small>&raquo;</small></h3>%s</div>', $atts['class'],$sidebar_contents);
	//return $sidebar_contents;
}

function widget_text_func( $atts ) {
	global $wpdb;
	// Configure defaults and extract the attributes into variables
	extract( shortcode_atts( 
		array( 
			'type'  => '',
			'title' => '',
			'id'    => '',
			'class' => ''
		), 
		$atts 
	));
	$atts['q'] = 'select * from wp_options where option_name like "widget_text"';
	$atts['results'] = maybe_unserialize(current($wpdb->get_results($atts['q']))->option_value);
	//say($atts);
	return sprintf('<div class="%s">%s</div>', $atts['class'], $atts['results'][$atts['id']]['text']);
}

function skedco_hero_funcNO($atts) {
	global $post;
	$post->hero = new stdClass();
	$post->hero->headline = get_field('headline');
	$post->hero->subhead = get_field('subhead');
	$post->hero->button_text = get_field('button_text');
	$post->hero->img = get_featured_image_url($post->ID);
	//say($post);
	return '<p><strong>Skedco Hero Image.</strong></p>';
}

function skedco_login_funcNO($atts) {
	extract( shortcode_atts( 
		array( 
			'echo'           => true,
			'redirect'       => site_url( $_SERVER['REQUEST_URI'] ), 
    	    'form_id'        => 'loginform',
			'label_username' => __( 'Username' ),
			'label_password' => __( 'Password' ),
			'label_remember' => __( 'Remember Me' ),
			'label_log_in'   => __( 'Log In' ),
			'id_username'    => 'user_login',
			'id_password'    => 'user_pass',
			'id_remember'    => 'rememberme',
			'id_submit'      => 'wp-submit',
			'remember'       => true,
			'value_username' => NULL,
			'value_remember' => false
		), 
		$atts 
	));
	ob_start();
	wp_login_form( $atts );
	$login_form = ob_get_clean();
	if ( is_user_logged_in() ) {
		$link['logout'] = '<a href="' . wp_logout_url( $_SERVER['REQUEST_URI'] ) . '" title="Logout">Logout</a>';
		$current_user = wp_get_current_user();
		$user_message = '<p>Welcome, ' . $current_user->display_name . '! ' . $link['logout'];
	} else {
		$user_message = $login_form;
	}
	return $user_message;
}

function skedco_rescue_line_index_func() {
	$content = do_shortcode('[skedco_content type="cat" val="rescue-industry-news"]');
	$content .= do_shortcode('[skedco_content type="cat" val="life-saving-training-techniques"]');
	$content .= '<br class="clear hidden-xs" />';
	$content .= do_shortcode('[skedco_content type="cat" val="rescue-equipment-blog"]');
	$content .= do_shortcode('[skedco_content type="cat" val="military"]');
	$content .= '<br class="clear hidden-xs" />';
	$content .= do_shortcode('[skedco_content type="cat" val="skedco-news" class="col-sm-6"]');
	$forum   = do_shortcode('[skedco_forum class="col-sm-6 fp-forum"]');
	return $content . $forum;
}

function skedco_industry_solutions_func($atts) {
	extract( shortcode_atts( 
		array( 
			'tags'           => ''
		), 
		$atts 
	));
	$a = array();
	foreach ( explode(',',$tags) as $t) {
		$t = get_term_by('slug',$t,'product_tag');
		if ($t) {
			$a[] = sprintf('<div class="col-sm-6 %s">', $t->slug);
			$a[] = sprintf('<h2><a href="%s">%s</a> <small><a href="%s">See All &raquo;</a></small></h2>', $t->slug, $t->name, $t->slug);
			$a[] = do_shortcode('[featured_product_categories cats="' . $t->term_id . '" per_cat="2" columns="2" tax="product_tag"]');
			$a[] = '</div>';
		}
	}
	return implode("\n", $a);
}

function skedco_about_menu_func() { 

return '

<p class="" style="clear:both;">&nbsp;</p>

<hr />

<p>
	<a href="/about/our-story/">Our Story</a>
	| 
	<a href="/about/our-leadership/">Our Leadership</a>
	|
	<a href="/about/our-mission/">Our Mission</a>
	|
	<a href="/about/faqs/">FAQs</a>
	|
	<a href="/about/catalogs/">Catalogs</a>
	|
	<a href="/about/brochures/">Brochures</a>
	|
	<a href="/about/contact/">Contact</a>
</p>
<br />

';

}

function skedco_login_page_func() {
	//$_ = array('<style>.woocommerce #customer_login {border:1px solid red;}</style>');
	if (!is_user_logged_in()) {
		//$_[] = 'Lo';
	}
	return implode("\n",$_);
}



add_shortcode( 'skedco_content'  , 'skedco_content_func' );
add_shortcode( 'skedco_forum','skedco_forum_func');
add_shortcode( 'widget_text', 'widget_text_func' );
add_shortcode( 'skedco_hero', 'skedco_hero_func' );
add_shortcode( 'skedco_login' , 'skedco_login_func');
add_shortcode( 'skedco_rescue_line_index' , 'skedco_rescue_line_index_func');
add_shortcode( 'skedco_industry_solutions','skedco_industry_solutions_func');
add_shortcode( 'skedco_about_menu' , 'skedco_about_menu_func');
add_shortcode( 'skedco_login_page' , 'skedco_login_page_func' ); 
?>