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

<!--<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_post_thumbnail('thumbnail',array('class'=>'floatleft')); ?></a>-->
<h2 class="stacked secondary-font"><big><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></big></h2>

<small class="secondary-font date">
	<span class="floatleft"><?php the_date() ?></span>
	<span class="floatright"><?php echo trim($output, $separator) ?></span>
</small>
<br class="clear" />
<div class="reading-font"><?php the_excerpt() ?></div>

<p>&nbsp;</p><br class="clear" />