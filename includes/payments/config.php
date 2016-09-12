<?php
if ( ! defined( 'ABSPATH' ) ) exit;
	//define( "LOG_FILE", WP_CONTENT_DIR."/ipn.log");// in root website directory)
	define( "LOG_FILE", get_template_directory()."/includes/payments/ipn.log");// in root website directory)
	define( 'DEBUG_PAYMENT', true);
	define( 'PT_ORDER', 'order');

	include_once('class_order.php');
	include_once('class_paypal.php');
?>