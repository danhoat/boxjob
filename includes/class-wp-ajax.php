<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WooCommerce WC_AJAX.
 *
 * AJAX Event Handler.
 *
 * @class    WC_AJAX
 * @version  2.4.0
 * @package  WooCommerce/Classes
 * @category Class
 * @author   WooThemes
 */
class JB_AJAX {

	/**
	 * Hook in ajax handlers.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'define_ajax' ), 0 );
		add_action( 'template_redirect', array( __CLASS__, 'do_wc_ajax' ), 0 );
		self::add_ajax_events();
	}

	/**
	 * Get WC Ajax Endpoint.
	 * @param  string $request Optional
	 * @return string
	 */
	public static function get_endpoint( $request = '' ) {
		return esc_url_raw( add_query_arg( 'wc-ajax', $request, remove_query_arg( array( 'remove_item', 'add-to-cart', 'added-to-cart' ) ) ) );
	}

	/**
	 * Set WC AJAX constant and headers.
	 */
	public static function define_ajax() {
		if ( ! empty( $_GET['wc-ajax'] ) ) {
			if ( ! defined( 'DOING_AJAX' ) ) {
				define( 'DOING_AJAX', true );
			}
			if ( ! defined( 'WC_DOING_AJAX' ) ) {
				define( 'WC_DOING_AJAX', true );
			}
			// Turn off display_errors during AJAX events to prevent malformed JSON
			if ( ! WP_DEBUG || ( WP_DEBUG && ! WP_DEBUG_DISPLAY ) ) {
				@ini_set( 'display_errors', 0 );
			}
			$GLOBALS['wpdb']->hide_errors();
		}
	}

	/**
	 * Send headers for WC Ajax Requests
	 * @since 2.5.0
	 */
	private static function wc_ajax_headers() {
		send_origin_headers();
		@header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
		@header( 'X-Robots-Tag: noindex' );
		send_nosniff_header();
		nocache_headers();
		status_header( 200 );
	}

	/**
	 * Check for WC Ajax request and fire action.
	 */
	public static function do_wc_ajax() {
		global $wp_query;

		if ( ! empty( $_GET['wc-ajax'] ) ) {
			$wp_query->set( 'wc-ajax', sanitize_text_field( $_GET['wc-ajax'] ) );
		}

		if ( $action = $wp_query->get( 'wc-ajax' ) ) {
			self::wc_ajax_headers();
			do_action( 'wc_ajax_' . sanitize_text_field( $action ) );
			die();
		}
	}

	/**
	 * Hook in methods - uses WordPress ajax handlers (admin-ajax).
	 */
	public static function add_ajax_events() {
		// woocommerce_EVENT => nopriv
		$ajax_events = array(
			'jb_signin'         	=> true,
			'bx_signup' 			=> true,
			'apply_coupon'     		=> true,
			'jb_signout' 			=> false,
			'syn_post_job' 		 	=> false,
			'bj_plupload_action' 	=> true,
			'sync_profile' 			=> false,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );

			if ( $nopriv ) {
				// user nog logged
				add_action( 'wp_ajax_nopriv_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}
	/**
	 * ajax login after submit modal login form
	 * @since   1.0
	 * @author danng
	 * @return json
	 */
	public static function jb_signin(){



		$request 	= $_REQUEST;
		$info 		= $request['request'];
		/*
		 * check security
		 */
		if( !wp_verify_nonce( $info['nonce_login_field'], 'jb_login_action' ) ) {
			wp_send_json(array( 'success' => false, 'msg'=> 'The nonce field is incorrect','boxtheme') ) ;
	    }
	    $response = bx_signon($info);
	    wp_send_json( $response );


	}
	/**
	 * signout curren user
	 * @since   1.0
	 * @author danng
	 * @return  json
	 */
	public static function jb_signout(){
		wp_logout();
		$response = array( 'success' => true, 'msg' => __( 'You have logout successful', 'boxtheme') );
		wp_send_json( $response );
	}
	/**
	 * catch the ajax for job process.
	 * @version [version]
	 * @since   1.0
	 * @author danng
	 * @return  ajax
	 */
	public static function syn_post_job(){
		$request 	= $_REQUEST;
		$form 		= $request['request'];
		$method 	= $request['method'];
		$response = array('success' => false, 'msg' => __('Insert sample fail'), 'data' => array() );

		$return = JB_Job::sync($method, $form);

		if ( !is_wp_error( $return ) ) {
			$response = array(
				'success' => TRUE,
				'msg' => __('Insert job successful','boxtheme'),
				'data' => get_post($return),
				);
		} else {
			$response = array(
				'success' 	=> 0,
				'msg' 		=> $return->get_error_message(),
				'data' 		=> array(),
			);
		}
		wp_send_json( $response );
	}
	public static function bx_signup(){
		$response = array(
				'success' 	=> false,
				'msg' 		=> __('Has something wrong', 'boxtheme'),
			);
		$request = $_REQUEST;

		$user = new bj_user();
		if ( empty($request['user_pass']) )
			$request['user_pass'] = wp_generate_password( 12, true );

		$user_id = $user->sync( $request, 'created');

		if ( ! is_wp_error( $user_id ) ) {
			//auto login
			bx_signon($request);
			$response = array(
				'success' 	=>	true,
				'redirect_url' => bx_get_static_link('profile'),
				'msg' 		=> __('You have registered successful','boxtheme'),
				'data' 		=> get_userdata($user_id)
			);
		} else {
			$response['msg'] =  $user_id->get_error_message();
		}
		wp_send_json($response );
	}
	function sync_profile(){
		$request 	= $_REQUEST;
		$method 	= isset($request['method']) ? $request['method'] : '';
		$response 	= array('success' => true, 'msg'=> __('You have updated profile successfull','boxtheme') );
		$profile 	= new bj_profile();
		$profile_id = $profile->sync($request, $method);

		if( is_wp_error( $profile_id )){
			$response = array('success' => false,'msg' =>$profile_id->get_error_message());
		}
		wp_send_json($response );

	}



	/**
	 * upload file via pupload js
	 * @since  1.0
	 * @author danng
	 */

	function bj_plupload_action(){
		$imgid = $_POST["imgid"];
    	//check_ajax_referer($imgid . 'pluploadan');
		$uploadedfile = $_FILES[$imgid . 'async-upload'];


		$upload_overrides = array( 'test_form' => false );

		$uploaded_file = wp_handle_upload( $uploadedfile, $upload_overrides );

	    $filename =$uploaded_file['url'];
	    $filetype = wp_check_filetype( basename( $filename ), null );

		// Get the path to the upload directory.
		$wp_upload_dir = wp_upload_dir();


        //if there was an error quit early
        if (isset($uploaded_file['error'])) {
        	wp_send_json( array('success'=> false, 'msg' => 'fail' ) );
            return new WP_Error('upload_error', $uploaded_file['error']);
        } elseif (isset($uploaded_file['file'])) {

            // The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
            $file_name_and_location = $uploaded_file['file'];

            // Generate a title for the image that'll be used in the media library
            $file_title_for_media_library = sanitize_file_name($file['name']);

            $wp_upload_dir = wp_upload_dir();

            // Set up options array to add this file as an attachment
            global $user_ID;
            $attachment = array(
                'guid' => $uploaded_file['url'],
                'post_mime_type' => $uploaded_file['type'],
                'post_title' => $file_title_for_media_library,
                'post_content' => '',
                'post_status' => 'inherit',
                'post_author' => $user_ID
            );

            // Run the wp_insert_attachment function. This adds the file to the media library and generates the thumbnails. If you wanted to attch this image to a post, you could pass the post id as a third param and it'd magically happen.
            $attach_id = wp_insert_attachment($attachment, $file_name_and_location, $parent);
            require_once (ABSPATH . "wp-admin" . '/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file_name_and_location);
            wp_update_attachment_metadata($attach_id, $attach_data);
            wp_send_json( array('success' => true,'attach_id' => $attach_id) );


		}
	}
}

JB_AJAX::init();