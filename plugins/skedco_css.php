<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/*
  Plugin Name: Skedco - CSS
  Description: All the (conditional) css needed for the Skedco site.
  Author: CJ Stritzel
  Version: 1.0
 */


function skedco_css() {

 
 
}


 add_action('wp_footer', 'skedco_css', 20);
 ?>