<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */
global $woo_options, $woocommerce;

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php if (!class_exists('woocommerce')) echo 'woocommerce-deactivated'; ?>">
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<title><?php woo_title(''); ?></title>
<?php woo_meta(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	wp_head();
	woo_head();
?>
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Roboto:400,100,100italic,300,300italic,500,400italic,500italic,700,700italic,900,900italic:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>

</head>

<body <?php body_class(); ?>>
<?php woo_top(); ?>

<div id="wrapper">



	<!--<div id="top">-->
		<!--
		<nav class="col-full" role="navigation">
			<?php if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'top-menu' ) ) { ?>
			<?php wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'top-nav', 'menu_class' => 'nav fl', 'theme_location' => 'top-menu' ) ); ?>
			<?php } ?>
			<?php
				if ( class_exists( 'woocommerce' ) ) {
					echo '<ul class="nav wc-nav">';
					woocommerce_cart_link();
					echo '<li class="checkout"><a href="'.esc_url($woocommerce->cart->get_checkout_url()).'">'.__('Checkout','woothemes').'</a></li>';
					echo get_search_form();
					echo '</ul>';
				}
			?>
		</nav>
		-->
	<!--</div>--><!-- /#top -->



    <?php woo_header_before(); ?>

	<header id="header" class="col-full">

		

	    <hgroup>

	    	 <?php
			    $logo = esc_url( get_template_directory_uri() . '/images/logo.png' );
				if ( isset( $woo_options['woo_logo'] ) && $woo_options['woo_logo'] != '' ) { $logo = $woo_options['woo_logo']; }
				if ( isset( $woo_options['woo_logo'] ) && $woo_options['woo_logo'] != '' && is_ssl() ) { $logo = preg_replace("/^http:/", "https:", $woo_options['woo_logo']); }
			?>
			<?php if ( ! isset( $woo_options['woo_texttitle'] ) || $woo_options['woo_texttitle'] != 'true' ) { ?>
			    <a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr( get_bloginfo( 'description' ) ); ?>">
			    	<img src="<?php echo $logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
			    </a>
		    <?php } ?>


			<h1 class="site-title mobile"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description mobile"><?php bloginfo( 'description' ); ?></h2>
			<h3 class="nav-toggle"><a href="#navigation">&#9776; <span><?php _e('Navigation', 'woothemes'); ?></span></a></h3>

		</hgroup>

        <?php woo_nav_before(); ?>

		
		<nav id="navigation" class="col-full" role="navigation">

			<?php
			if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fr', 'theme_location' => 'primary-menu' ) );
			} else {
			?>
	        <ul id="main-nav" class="nav fl">
				<?php if ( is_page() ) $highlight = 'page_item'; else $highlight = 'page_item current_page_item'; ?>
				<li class="<?php echo $highlight; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Home', 'woothemes' ); ?></a></li>
				<?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
			</ul><!-- /#nav -->
	        <?php } ?>

			<ul id="sub-nav" class="fl">
				
				<li id="youtube"><a href="http://www.youtube.com/user/skedcoInc" target="_blank">YT</a></li>
				<li id="google"><a href="https://plus.google.com/115546381465209422158/about" target="_blank">G+</a></li>
				<li id="facebook"><a href="https://www.facebook.com/pages/Skedco/214181008646361" target="_blank">F</a></li>
				<li id="search"><form action="<?php echo home_url() ?>"><input type="search" name="s" placeholder="Search..."></form><!--<a href="javascript:void();">S</a>--></li>
				<li id="cart">
				<?php global $woocommerce; ?>
					<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">(<?php cart_count(); ?>)</a>
				</li>
			</ul>

		</nav>
		<!-- /#navigation -->

		<?php woo_nav_after(); ?>

	</header><!-- /#header -->

	<?php woo_content_before(); ?>

	<?php //say($woocommerce->cart->cart_contents) ?>