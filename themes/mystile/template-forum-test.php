<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Template Name: Forums Test Template
 *
 * This is a test template for the Forums
 */
 
 while ( have_posts() ) { the_post(); ?>
 
 <h1><?php the_title(); ?></h1>

<?php the_content(); ?>

<?php }
 $rl = new RedirectList;
 say($rl);
 
 
 $fl = new ForumList;
 say($fl);
 
?>

