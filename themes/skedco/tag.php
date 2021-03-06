<?php get_header(); ?>
<div class="masthead tag">
	<img src="<?php skedco_random_hero_img() ?>" />
</div>
<div class="container">

	<main role="main">
		<!-- section -->
		<section>
		<div class="row">
		  <div class="col-xs-12">
  			<h1><?php _e( 'From the Rescue Line: ', 'skedco' ); echo single_tag_title('', false); ?></h1>
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

