<?php global $woocommerce; ?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<link rel="stylesheet" type="text/css" href="//cloud.typography.com/7297512/723724/css/fonts.css" />
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap/dist/css/skedco.ie.css" />

	</head>
	<body <?php body_class(); ?>>

	<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>

		<header class="header" role="banner">
		  <div class="navbar-wrapper-wrapper">
        <div class="container">
        </div>
		  </div>
      <div class="navbar-wrapper">
        <div class="container">
  
          <div class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo home_url(); ?>">
                  <!-- svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script -->
                  <!-- <img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="Logo" class="logo-img"> -->
                  <?php echo $blog_title = get_bloginfo(); ?>
                </a>
              </div> <!-- /navbar-header -->
              <div class="navbar-collapse collapse">
      					<!-- nav -->
      					<nav class="nav" role="navigation">
      						<?php skedco_nav(); ?>
      					</nav>
                <div class="cart">
                  <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><span class="glyphicon glyphicon-shopping-cart"></span> (<?php echo $woocommerce->cart->cart_contents_count ?>)</a>
                </div>
      					<div class="social-links">
      					  <a href=".search-box" class="search-trigger collapsed" data-toggle="collapse"><span class="glyphicon glyphicon-search"></span></a>
      					  <a href="http://www.youtube.com/user/skedcoInc" target="_blank" class="youtube" target="_blank">Youtube</a>
      					  <a href="https://plus.google.com/115546381465209422158/about" class="gplus" target="_blank">Google+</a>
      					  <a href="https://www.facebook.com/pages/Skedco/214181008646361" class="fb" target="_blank">Facebook</a>
                </div>
                <?php get_search_form(); ?>
              </div> <!-- /navbar-collapse collapse -->
            </div> <!-- /container -->
          </div> <!-- /navbar navbar-inverse navbar-static-top -->
  
        </div> <!-- /container -->
      </div> <!-- /navbar-wrapper -->
    </header> <!-- /header -->
   
