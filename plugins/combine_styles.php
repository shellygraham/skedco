<?php
/*
Plugin Name: Popart Combine Styles
Plugin URI: http://www.nonlefthanded.com/plugins
Description: WP, WooCommerce, Ninja Forms and BBPress all have message styles, this combines them. Standard is the WooCommerce one, but easily alterable. Also putting "Product Nugget" styles in here.
Version: 1.0
Author: CJ Stritzel
Author URI: http://www.nonlefthanded.com/plugins
*/
add_action('wp_footer', 'combine_styles', 100);
function combine_styles() { ?>

<style>

/* 7.1 Messages */
.woocommerce_message,
.woocommerce_info,
.woocommerce_error,
.woocommerce-message,
.woocommerce-info,
.woocommerce-error,
.ninja-forms-error div,
.ninja-forms-success-msg p span,
#ninja_forms_form_2_process_msg,
.bbp-template-notice.info p {
	padding: .618em 1em .618em 2.618em;
	margin-bottom: 1.618em;
	background: #fff;
	border: 1px solid #4d65a4;
	border-left-width: .382em ;
	position: relative;
	font-weight: bold;
	margin-top:1em;
	/* margin-right:4%; */
	display:block;
}
.woocommerce_message:before,
.woocommerce_info:before,
.woocommerce_error:before,
.woocommerce-message:before,
.woocommerce-info:before,
.woocommerce-error:before,
.ninja-forms-error div:before,
.ninja-forms-success-msg p span:before,
.bbp-template-notice.info p:before {
	font-family: 'WebSymbolsRegular';
	content: "S";
	display: block;
	color: #4d65a4;
	font-weight: normal;
	position: absolute;
	top: .618em;
	font-size: 1em;
	left: .857em;
}
.woocommerce_error,
.woocommerce-error,
.ninja-forms-error div {
	border-color: #b85f56;
	list-style: none;
	color:#b85f56;
}
.woocommerce_error:before,
.woocommerce-error:before,
.ninja-forms-error div:before {
	content: "W";
	color: #b85f56;
}
.woocommerce_message,
.woocommerce-message,
.ninja-forms-success-msg p span {
	border-color: #84ac50;
	color: #84ac50;
}
.woocommerce_message:before,
.woocommerce-message:before,
.ninja-forms-success-msg p span:before {
	content: ".";
	color: #84ac50;
}
.woocommerce_message .button,
.woocommerce-message .button,
.ninja-forms-success-msg p span .button {
	float: right;
	font-size: .857em;
}

.woocommerce .woocommerce-info:before, .woocommerce-page .woocommerce-info:before {
	background-color:transparent !important;
}
.ninja-forms-success-msg p { display:inline; } /* There's random paragraphs surrounding this message, takes away some vert space. */
#ninja_forms_form_2_process_msg { color:#999; padding-left:1em !important; }
.bbp-template-notice.info {border:0px !important; padding:0px !important;}

</style>

<?php } ?>