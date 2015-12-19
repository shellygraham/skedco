<?php get_header(); ?>

<div class="masthead single">
  <img src="<?php skedco_random_hero_img() ?>" />
</div>
<div class="container">

	<main role="main" class="<?php echo get_post_type() ?>">
		<!-- section -->
		<section>
		<div class="col-md-8">
  
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


			<!-- post title -->
			<h1>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h1>
			<!-- /post title -->

			<!-- post details -->
			<span class="date left"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
			<span class="author right"><?php _e( 'Published by', 'skedco' ); ?> <?php the_author_posts_link(); ?></span>
			<!-- /post details -->
			
			<br class="clear" />
			
			<?php the_content(); // Dynamic Content ?>

			<br class="clear" />
			<p>
				<?php the_tags( __( 'Tags: ', 'skedco' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>
				<?php _e( 'Categorised in: ', 'skedco' ); the_category(', '); // Separated by commas ?>
				<!-- <p><?php _e( 'This post was written by ', 'skedco' ); the_author(); ?></p> -->
			</p>

			<?php // comments_template(); ?>

		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'skedco' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>		</div>
		</section>
		<!-- /section -->
	</main>
<div class="col-md-4">
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>

