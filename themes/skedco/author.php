<?php get_header(); ?>
<div class="masthead author">
	<img src="<?php skedco_random_hero_img() ?>" />
</div>
<div class="container">

	<main role="main">
		<!-- section -->
		<section>
		<div class="row">
		  <div class="col-xs-12">
  
		<?php if (have_posts()): the_post(); ?>

			<h1><?php _e( 'Author Archives for ', 'skedco' ); echo get_the_author(); ?></h1>

		  </div>
		</div>
		<div class="col-md-8">

			<?php if ( get_the_author_meta('description')) : ?>

			<?php echo get_avatar(get_the_author_meta('user_email')); ?>

			<h2><?php _e( 'About ', 'skedco' ); echo get_the_author() ; ?></h2>

			<?php echo wpautop( get_the_author_meta('description') ); ?>

		<?php endif; ?>

		<?php rewind_posts(); ?>


			



		

		<?php endif; ?>


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

