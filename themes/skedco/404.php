<?php get_header(); ?>
<div class="masthead 404">
  <img src="<?php skedco_random_hero_img() ?>" />
</div>
<div class="container">

	<main role="main">
		<!-- section -->
		<section>
		<div class="row">
		<div class="col-md-12">
  
			<!-- article -->
			<article id="post-404">

				<h1><?php _e( 'Page not found', 'skedco' ); ?></h1>
				<h2>
					<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'skedco' ); ?></a>
				</h2>

			</article>
			<!-- /article -->
		</div>
		</div>
		</section>
		<!-- /section -->
	</main>
</div>
<?php get_footer(); ?>
