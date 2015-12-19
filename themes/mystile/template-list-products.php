<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Template Name: List Products
 *
 * The blog page template displays a list of all the products (for deleting extra products).
 *
 * @package WooFramework
 * @subpackage Template
 */
 ?>
 
 <style>
 
 

 
 
table {
  border-collapse: separate;
  background:#fff;
  @include border-radius(5px);
  margin:50px auto;
  @include box-shadow(0px 0px 5px rgba(0,0,0,0.3));
}

thead {
  @include border-radius(5px);
}

thead th {

  font-size:26px;
font-family:sans-serif;
  font-weight:400;
  /* color:#fff; */
  @include text-shadow(1px 1px 0px rgba(0,0,0,0.5));
  text-align:left;
  padding:0 20px;
  @include background-image(linear-gradient(#646f7f, #4a5564));
  border-top:0px solid #858d99;
border-bottom:1px solid #858d99;
  
  &:first-child {
   @include border-top-left-radius(5px); 
  }

  &:last-child {
    @include border-top-right-radius(5px); 
  }
}

tbody tr td {
  font-family: 'Open Sans', sans-serif;
  font-weight:400;
  color:#5f6062;
  font-size:13px;
  padding:20px 20px 20px 20px;
  border-bottom:1px solid #e0e0e0;
  
}

tbody tr:nth-child(2n) {
  background:#f0f3f5;
}

tbody tr:last-child td {
  border-bottom:none;
  &:first-child {
    @include border-bottom-left-radius(5px);
  }
  &:last-child {
    @include border-bottom-right-radius(5px);
  }
}

tbody:hover > tr td {
  @include opacity(0.5);
  
  /* uncomment for blur effect */
  /* color:transparent;
  @include text-shadow(0px 0px 2px rgba(0,0,0,0.8));*/
}

tbody:hover > tr:hover td {
  @include text-shadow(none);
  color:#2d2d2d;
  @include opacity(1.0);
}

img {
	height:90px;
	width:90px;
}

 </style>
<?php 
	$i = 1;
	$args = array(
	'posts_per_page'   => 300,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'title',
	'order'            => 'ASC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'product',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true ); 
?>
	<table>
	<thead><tr>
		<th></th>
		<th>Image</th>
		<th>Title</th>
		<th>Remove</th>
		<th>SKU#/Price/Weight</th>
		<th>Category</th>
		<th>Industry</th>
		<th>Stand&nbsp;Alone</th>
		<th>Combine</th>
		<th>Part&nbsp;of</th>
	</tr></thead><tbody>
	<?php 
		// say(get_posts( $args )); 
		foreach (get_posts( $args ) as $p) { ?>
		
		<?php
			setup_postdata( $GLOBALS['post'] =& $p );
			global $post;
			$_cats = array();
			$cats = get_the_terms( $p->ID, 'product_cat' );
			//say($cats);
			foreach ($cats as $cat) {
			 	$_cats[] = $cat->name;
			}
			$cats = implode(", ", $_cats);
			
			$_tags = array();
			$tags = get_the_terms( $p->ID, 'product_tag' );
			//say($cats);
			foreach ($tags as $tag) {
			 	$_tags[] = $tag->name;
			}
			$tags = implode(", ", $_tags);
			
			$sku = get_post_meta( $p->ID, '_sku', true);
			if (!$sku) {$sku = '______________';}
			$price = get_post_meta( $p->ID, '_regular_price', true);
			if (!$price) {$price = '________';}
			$weight = get_post_meta( $p->ID, '_weight', true);
			if (!$weight) {$weight = '________';}
			
			//$img = get_post_thumbnail_id( $p->ID );
			//$img = get_the_post_thumbnail($p->ID, 'thumbnail');
			$img = (get_the_post_thumbnail($p->ID, 'thumbnail')) ? get_the_post_thumbnail($p->ID, 'thumbnail') : 'NO IMAGE' ;
		?>

			<tr>
			<td style="text-align:right;"><?php echo $i++ ?>.</td>
			<td><?php echo $img ?></td>
			<td>
				<big><strong><?php the_title() ?></strong></big> <br /><small>ID: <?php echo $p->ID ?></small>
				
				<hr />
				<?php echo $p->post_name ?>
				
				<?php if (get_post_meta( $p->ID, '_visibility', true) == 'hidden') { ?>
				<p><small><strong style="color:red;">HIDDEN</strong></small></p>
				<?php } ?>
				<p><a href="<?php echo home_url('/wp-admin/post.php?action=edit&post=') ?><?php echo $p->ID ?>" target="_blank">edit</a> | <a href="<?php the_permalink() ?>" target="_blank">view</a>
			</td>
			<td>&nbsp;</td>
			<td>SKU: <strong><?php echo $sku ?></strong><p>PRICE: <strong>$<?php echo $price ?></strong><p>WEIGHT: <strong><?php echo $weight ?>lbs.</strong></td>
			<td><?php echo $cats ?></td>
			<td><?php echo $tags ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
			<tr><td colspan='10'><?php the_content() ?></td></tr>
		<?php }
	?>
	</tbody></table>