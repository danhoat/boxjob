<?php
if ( ! defined( 'ABSPATH' ) ) exit;
	class JB_Order{
		function __construct(){
			//add_action( 'init' );
		}

		/**
		 * insert order item
		 * @since   1.0
		 * @author danng
		 * @param   array post args default
		 * @return  int ID of order item
		 */
		function insert( $args ){
			$args = array(
				'post_type' => PT_ORDER,
				'post_status' => 'publish',
				'post_title' => 'Order'
				);
			$id = wp_insert_post($args);
			return $id;

		}

		function __destruct(){

		}

	}
?>