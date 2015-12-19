<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/*
  Plugin Name: Skedco - JS
  Description: All the JavaScript needed for the Skedco site.
  Author: CJ Stritzel
  Version: 1.0
 */
 function skedco_js() { ?>
 
 	<script>
	(function ($) {
 		$(document).ready(function() {
 			return removeForumDupes(); // Home Page ("Trending Topics," and "More Topics") dupe remover.
 			return change_industry_solutions_css();
 			
 		});
 		function removeForumDupes(){
 			forumQuestions = Array();
 			$('.fp-forum ul').each(function(){
 				$(this).children().each(function(){
 					in_array = forumQuestions.indexOf($(this).children().eq(0).html());
 					forumQuestions.push($(this).children().eq(0).html());
 					if (in_array != -1) { 
 						$(this).remove();
 					}
 				});
 			});
 		}
 		
 		function change_industry_solutions_css() {
 			$('.tax-product_tag header nav ul li#menu-item-836').addClass('active');
 		}
 		
 	}(jQuery));
 	</script>
 
 <?php }
 add_action('wp_footer', 'skedco_js', 20);
 ?>