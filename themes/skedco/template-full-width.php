<?php /* Template Name: Skedco Full-Width Template */ get_header(); ?>
<?php 
			if ($post->post_name == "industry-solutions") {
				get_template_part( 'skedco', 'carousel' );
			} 
		?>
<?php if ($post->post_name != "industry-solutions") { ?>
<div class="masthead">
	<img src="<?php skedco_random_hero_img() ?>" />
</div>
<?php } ?>

	<main role="main">
		<!-- section -->
		<section>
		
    <div class="container">

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<h1><?php the_title() ?></h1>
				
				<?php if (get_field('subhead')) { ?><h3 class="emphasis"><?php the_field('subhead'); ?></h3><?php } ?>

				<?php the_content(); ?>

				<br class="clear">

				<?php //edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'skedco' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
