<?php // "Ask Bud" post ID is 2021. ?>
<?php get_header(); ?>

<div class="masthead bbpress">
	<img src="<?php skedco_random_hero_img() ?>" />
</div>
<div class="container">

	<main role="main">
		<!-- section -->
		<section>
		<div class="row">
		  <div class="col-xs-12">
  			<h1><?php _e( the_title(), 'skedco' ); ?></h1>
  			<?php if ($post->ID == 2021) { ?>
  			<p>
  				Challenge the knowledge of the man who invented the Sked&trade;. 
  				Bud Calkin answers your professional rescue questions here on a regular basis.
  			</p>
  			<?php } ?>
		  </div>
		</div>
		<div class="col-md-8">


		<?php
			if (bbp_is_single_forum()) {
				echo do_shortcode('[bbp-single-forum id=' . $post->ID . ']');
			} else if (bbp_is_single_topic()) {
				echo do_shortcode('[bbp-single-topic id=' . $post->ID . ']');
			} else if (bbp_is_single_user()) {
				bbp_breadcrumb();
				echo $post->post_content;
			}
		?>

			<?php //get_template_part('loop'); ?>

			<?php //get_template_part('pagination'); ?>  

		</div>
		</section>
		<!-- /section -->
	</main>
<div class="col-md-4" id="sidebar">
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
