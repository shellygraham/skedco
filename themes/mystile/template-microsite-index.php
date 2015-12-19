<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Template Name: MicroSite Template (Index)
 *
 * The blog page template displays the index of all the "microsites." 
 *
 * @package WooFramework
 * @subpackage Template
 */

	// Adding the custom fields to the $post object...
	foreach((object)get_fields(get_the_ID()) as $k => $v ) {
		$post->$k = $v;
	}
	$args = array( 
		'post_parent' => $post->ID,
		'numberposts' => '100',
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	foreach((object)get_children($args) as $k => $v ) {
		foreach((object)get_fields($k) as $key => $val ) {
			$v->$key = $val;
		}
		$v->permalink = get_permalink( $k );
		$tmp[] = $v;
	};
	$post->children = $tmp;
	$i = 0;

 global $woo_options;
 get_header();
 

?>
    <!-- #content Starts -->
	<div id="content" class="col-full">
	
		<?php foreach ($post->children as $p) { ?>

		<div class="sixcol-one<?php if ($i == 5){ ?> last<?php } ?>">
			<a href="<?php echo $p->permalink ?>"><?php echo $p->post_title ?></a>
		</div>
		
		<?php $i++ ?>
		<?php } ?>

		<?php //say($post) ?>

    </div><!-- /#content -->    
		
<?php get_footer(); ?>