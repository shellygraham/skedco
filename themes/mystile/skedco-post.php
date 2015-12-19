<?php global $last ?>

	<li class="fourcol-one product type-product <?php echo $last ?>">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
			<?php the_post_thumbnail('thumbnail',array('class'=>'wp-post-image')); ?>
			<h3 class="stacked"><?php the_title(); ?></h3>
		</a>
	</li>
