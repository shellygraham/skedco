<?php
	$categories = get_the_category();
	$separator = ' ';
	$output = '';
	if($categories){
		foreach($categories as $category) {
			$output .= '<a class="secondary-link" href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
		}
	}
?>
<div class="threecol-one">
	<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('large',array('class' => 'fullwidth')); ?></a>
	<small class="caption"><?php echo get_field('photo_caption', get_the_ID()); ?></small>
</div>
<div class="threecol-two last">
	<?php echo trim($output, $separator) ?>
	<h2 class="stacked secondary-font"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
	<small class="secondary-font"><?php the_date() ?></small>
	<br />
	<div class="reading-font"><?php the_excerpt() ?></div>
	<?php share_this_buttons() ?>
</div>

<br class="clear" />