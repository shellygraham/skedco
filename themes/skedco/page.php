<?php get_header(); ?>
<div class="masthead page">
  <?php //if ( has_post_thumbnail() ) {
	//the_post_thumbnail();
//} else { ?>
	<img src="<?php skedco_random_hero_img() ?>" />
<?php //} ?>
</div>
<div class="container">

	<main role="main">
		<!-- section -->
		<section>
  		<div class="row">
  		  <div class="col-xs-12">
    			<h1><?php the_title(); ?></h1>
  		  </div>
  		</div>
  		<div class="row">
    		<div class="col-md-8">
      
      		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
      
      			<!-- article -->
      			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      			  <?php
                if(get_field('meta_description'))
                  {
                  	echo '<h2 class="lead-in">' . get_field('meta_description') . '</h2>';
                  }
                ?>
      
      				<?php the_content(); ?>
      
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
    		</div>
        <div class="col-md-4">
        <?php get_sidebar(); ?>
        </div>
  		</div>
		</section>
		<!-- /section -->
	</main>
</div>
<?php get_footer(); ?>
