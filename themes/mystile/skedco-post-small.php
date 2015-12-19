<?php remove_filter( 'the_excerpt', insert_featured_image_excerpt, 20 ); ?>
<?php global $last ?>

	<li class="twocol-one content-small <?php echo $last ?>">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
			<?php the_post_thumbnail(array(90,90), array('class' => 'floatleft small border')); ?>
		</a>
		<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
		<?php the_excerpt() ?>
		<!--<small class="block alignright"><a href="<?php the_permalink() ?>">Read More &raquo;</a></small>-->
	</li>
