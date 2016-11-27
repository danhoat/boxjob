<?php
if ( ! defined( 'ABSPATH' ) ) exit;
	class JB_Job {

		private static $instance;
		function __construct(){
			add_filter( 'query_vars',array( $this, 'add_query_vars_filter' ) );
			add_filter( "template_include", array($this, "custom_template_redirect" ) );
			add_action( 'template_redirect', array($this, 'jb_template_redirect' ));

		}
		function get_meta_fields(){
			return array(
				'jb_lat',
				'jb_lng',
				'full_address',
				'_thumbnail_id',
			);
		}
		function add_query_vars_filter($vars ){

			$vars[] = "keyword";

  			return $vars;
		}
		function custom_template_redirect($template){
			return $template;
		}
		function jb_template_redirect(){
			if ( is_page_template( 'page-signup.php' ) && is_user_logged_in() ) {
				wp_redirect( home_url());
        		exit();
			}
		}
		static function get_instance(){

			if (null === static::$instance) {
            	static::$instance = new static();
        	}
        	return static::$instance;
		}
		static function sync( $method, $request ) {

			$instance = self::get_instance();
			$form = $instance->check_security($method, $request);
			if( is_wp_error( $form )){
				return $form;
			}

			$respond = 0;
			switch ($method) {
				case 'insert':
					$respond = $instance->insert($request);
					return $respond;
					break;
				case 'update':
					$instance->update($request);
					break;
				case 'delete':
					$instance->delete($request);
					break;
				default:
					# code...
					break;
			}
			return $respond;
		}

		/**
		 * check security
		 * @since   1.0
		 * @author danng
		 * @param   [type]    $request [description]
		 * @return  [type]             [description]
		 */
		function check_security($method, $request){
			$name = "nonce_insert_job";
			if($method == 'edit')
				$name = "nonce_edit_job";
	    	if(! wp_verify_nonce( $request[$name], 'jb_submit_job' ) ){
	    		return  new WP_Error( 'unsecurity', __( "Has something wrong", "boxtheme" ) );
	    	}
	    	return true;
		}
		function insert($request){
			global $user_ID;
			$default = array(
				'post_type' 	=> 'job',
				'post_author' 	=> $user_ID,

			);
			// check security
			$check = $this->check_validate($request);
			if ( is_wp_error( $check ) ){
				return $check;
			}
			$tax_input 	= $request['tax_input'];
			$cat_id 		= isset($tax_input['job_cat'])  ? (int)$tax_input['job_cat'] : 0;
			$location 	= isset($tax_input['location']) ? (int)$tax_input['location'] : 0;
			$request 	= wp_parse_args( $request, $default);

			if(	$cat_id ){
				$tax_input['job_cat'] = array($cat_id);
			}

			$type_id = isset( $tax_input['type'] ) ? (int) $tax_input['type'] : 0;

			if(	$type_id ){
				$tax_input['type'] = array($cat_id);
			}
			if(	$location ){
				$tax_input['type'] = array($location);
			}

			$request['tax_input'] = $tax_input;
			$request['post_status'] = $this->get_post_status_step_2();

			$args 	= apply_filters( 'args_pre_insert_job', $request );

			$job_id = wp_insert_post( $request );

			if ( ! is_wp_error( $job_id ) ) {
				$meta_fields = self::get_meta_fields();
				foreach ($meta_fields as $key => $value) {

					if( isset( $request[$value] ) ) {
						update_post_meta( $job_id, $value, $request[$value] );
					}
				}
			}
			return $job_id;
		}
		/**
			check validte when post a job vai front-end.
		*/
		function check_validate($request){
			$validate = true;

			if( empty($request['post_title']) ){
				return  new WP_Error('empty_title',__('Empty job title','boxtheme'));
			}
			if( empty($request['post_content']) ){
				return new WP_Error('empty_content',__('Empty job content','boxtheme'));
			}
			if( empty($request['full_address']) ){
				return new WP_Error('empty_address',__('Empty job address','boxtheme'));
			}
			return $validate;
		}
		/**
		 * depend on the setting , use this method to get the post_status when insert new job.
		 * only use this method in step -2 of submit job page.
		 * @since   1.0
		 * @author danng
		 * @return  string post_status
		 */
		function get_post_status_step_2(){
			$post_status = 'draft';

			if( current_user_can('manager_options') )
				return 'publish';

			if( is_free_submit_job() ) {
				if ( is_admin_role() )
					return  'publish';
				if( is_pending_job() ){
					return 'pending';
				}
				return 'publish';
			}
			return $post_status;
		}

		public static function get_post_status_check_out(){
			if( is_admin_role() )
				return 'publish';
			if( is_pending_job() ){
					return 'pending';
			}
			return 'publish';
		}
	}
	new JB_Job();
?>