<?php get_header(); ?>
<div class="masthead archive-forum">
  <img src="<?php skedco_random_hero_img() ?>" />
</div>
<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>

<div class="container">
	
	<main role="main">
		<!-- section -->
		<section>
		<div class="row">
		  <div class="col-xs-12">
  			<h1><?php _e( 'Skedco Forums', 'skedco' ); ?></h1>
		  </div>
		</div>
		<div class="col-md-8">

			<p>
				Welcome to Skedco's Rescue Forums. 
				Here you can interact with Skedco staff, other Skedco customers and the global rescue community at-large. 
				You can browse posts anonymously and learn from amazing rescue stories that inspired our life-saving Skedco rescue products.
			</p>
			<p>
				If you would like to share your own rescue experiences or contribute your expertise, you must first authenticate via Facebook. 
				Participation is free and easy. 
				Please also review the first thread "<a href="/forums/forum/read-this-first-before-submitting-your-first-comment-or-topic/">*Read this first before submitting your first comment or topic*</a>" to ensure that the forums stay orderly and civilized.
			</p>

			<?php echo do_shortcode('[bbp-forum-index]') ?>

		</div>
		</section>
		<!-- /section -->
	</main>
<div class="col-md-4" id="sidebar">
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
