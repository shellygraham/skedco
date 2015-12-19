<?php
	$args = array(
		'hide_empty' => 0, 
		'orderby' => 'ASC', 
		'exclude' => '17,77'
	);
	$cat_terms = get_terms('product_cat', $args);
	$i = 1;
	global $woocommerce_loop;
	$woocommerce_loop['columns'] = 2;
	$woocommerce_loop['grid'] = 'twocol-one';
?>

<?php
	$not_in = array();
	foreach ($cat_terms as $cat_term) {
		$cat_posts = new ProductList('product_cat', $cat_term->slug, 2, $not_in);
		//say($cat_posts);
		$not_in = array_merge((array)$cat_posts->ids, (array)$not_in);
?>
	<div class="twocol-one<?php if (($i+1) % 4 == 0) { ?> last<?php } ?>">
	<?php printf('<h2><a href="%s%s">%s <small>SEE ALL &raquo;</small></a></h2>',home_url('/product-category/'),$cat_term->slug,$cat_term->name) ?>

		<!--<div class="products">-->
		<?php
			
				
			foreach ($cat_posts->products as $p) {
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
		<!--</div>-->
    </div>
    
<?php 
	}
?>



<br class="clear" />