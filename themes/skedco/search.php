<?php

 	////////////////////////////////////////////////////////////////////////////////
	//
	// Redirects from the old site will go to '/?s={last-segment-of-url}&redirect=1'
	// This loop goes through the options set in the admin to see where to redirect.
	// No match, it just does the search as usual.
	// SKU's and NSN's done later in the page on a "per-item" basis.
	//
	////////////////////////////////////////////////////////////////////////////////
 
	if ($_GET['redirect']) {
		$redirects = get_option('skedco_sample');
		foreach (explode("\n",$redirects['pairs']) as $pair) {
			$r = explode(',',$pair);
			if (trim(strtolower( get_search_query())) == strtolower(trim($r[0]))) {
				$redirect_to = home_url() . '/' . trim($r[1]);
				wp_redirect($redirect_to, 301 ); exit;
			}
 		}
 	}
?>
<?php get_header(); ?>
<div class="masthead">
  <img src="<?php skedco_random_hero_img() ?>" />
</div>
<div class="container">

	<main role="main">
		<!-- section -->
		<section>
		<div class="row">
		  <div class="col-xs-12">
  			<h1><?php echo sprintf( __( '%s Search Results for ', 'skedco' ), $wp_query->found_posts ); echo "\"" . get_search_query() . "\""; ?></h1>
		  </div>
		</div>
		<div class="col-md-8">
  
			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>
			
		</div>
		</section>
		<!-- /section -->
	</main>
<div class="col-md-4">
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
