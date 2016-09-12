<?php
class bj_profile{
	private $post_type;
	private $taxonomy;
	function __construct(){
		$this->post_type = PROFILE_PT;
		$this->taxonomy = array('skill');
	}
	function sync($args, $method){
		switch ($method) {
			case 'update':
				return $this->_update( $args );
				break;
			case 'insert':
				$this->_insert( $args );
				break;

			default:
				# code...
				break;
		}
	}
	function _insert(){

		$response = array('success' => true, 'msg' => __('You have created profile successfully','boxtheme') );
		$allow = $this->is_can_create_profile();
		if( !is_wp_error($allow) ){
			$profile_id = wp_insert_post($args);
			do_action( 'bx_after_insert_profile', $profile_id);
		} else {
			$response['success'] = false;
			$response['msg'] = $allow->get_error_message();
		}
	}

	function _update($args){

		$allow = $this->check_permission($args);

		if( !is_wp_error($allow) ){
			$args = $this->validate_meta($args);
			wp_set_post_terms( $args['ID'], $args['tax_input']['skill'], 'skill' );
			$profile_id = wp_update_post($args);
			do_action( 'bx_after_update_profile', $profile_id);
			return $profile_id;
		}
		return $allow;

	}
	function validate_meta($args){

		if(isset($args['skill'])){
			$skills = array_map('intval', $args['skill'] );
			$args['tax_input']['skill'] = $skills;
			unset($skills);
		}
		return $args;

	}
	function check_permission($args){
		$profile_id = isset($args['ID']) ? $args['ID'] :'';

		if( empty($profile_id) ){
			return new WP_Error( 'empty_profile', __( "The profile ID is empty", "boxtheme" ) );
		}
		if( ! is_user_logged_in() ){
			return new WP_Error( 'authenticate', __( "You are not login", "boxtheme" ) );
		}
		if( current_user_can( 'manage_options' ) ){
			return true;
		}
		$profile = get_post($profile_id);
		if($profile){
			global $user_ID;
			if($user_ID == $profile->post_author){
				return true;
			}
		}
		return new WP_Error( 'authenticate', __( "You are not allow to update this profile", "boxtheme" ) );
	}
	function is_can_create_profile(){
		global $user_ID;
		$profile_id = get_user_meta($user_ID, 'profile_id', true);
		$profile 	= get_post($profile_id);
		if(!$profile){
			return true;
		}
		return new WP_Error( 'authenticate', __( "You have a exists profile so can not create new", "boxtheme" ) );
	}
}
?>