<?php
	$tag_terms = get_terms('product_tag', array('include' => '51,48,39,50,49,16'));
	$i = 1;
	global $woocommerce_loop;
	$woocommerce_loop['columns'] = 2;
	$woocommerce_loop['grid'] = 'twocol-one';
	$not_in = array();
	foreach($tag_terms as $tag_term) {
		$tag_posts = new ProductList('product_tag', $tag_term->slug, 2, $not_in);
		$not_in = array_merge((array)$tag_posts->ids, (array)$not_in);
		//say($tag_posts);
		
?>

		<div class="twocol-one<?php if (($i+1) % 4 == 0) { ?> last<?php } ?>">
		<?php printf('<h2><a href="%s%s">%s <small>SEE ALL &raquo;</small></a></h2>',home_url('/product-category/'),$tag_term->slug,$tag_term->name) ?>

		<div class="products">
		<?php
			foreach ($tag_posts->products as $p) {
				setup_postdata( $GLOBALS['post'] =& $p );
				setup_postdata( $GLOBALS['product'] =& $p );
				
				// the \n's and \t's are for source readablilty.
				echo "\n\t\t";
				//printf('<div class="product-list twocol-one%s">',$p->last);
				woocommerce_get_template_part( 'content', 'product' );
				echo "\n\t\t";
				//print '</div>';
				echo "\n";

				$i++;
			}	
		?>
		</div>

		</div>

<?php } ?>
<br class="clear" />