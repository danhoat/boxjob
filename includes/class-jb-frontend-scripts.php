<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Handle frontend scripts
 *
 * @class       WC_Frontend_Scripts
 * @version     2.3.0
 * @package     WooCommerce/Classes/
 * @category    Class
 * @author      WooThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Frontend_Scripts Class.
 */
class JB_Frontend_Scripts {

	/**
	 * Contains an array of script handles registered by WC.
	 * @var array
	 */
	private static $scripts = array();

	/**
	 * Contains an array of script handles registered by WC.
	 * @var array
	 */
	private static $styles = array();

	/**
	 * Contains an array of script handles localized by WC.
	 * @var array
	 */
	private static $wp_localize_scripts = array();

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'wp_head',  array( __CLASS__, 'load_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );
		add_action( 'wp_print_scripts', array( __CLASS__, 'localize_printed_scripts' ), 5 );
		add_action( 'wp_print_footer_scripts', array( __CLASS__, 'localize_printed_scripts' ), 5 );
	}

	/**
	 * Get styles for the frontend.
	 * @access private
	 * @return array
	 */
	public static function get_styles() {
		return apply_filters( 'boxtheme_enqueue_styles', array(


			'font-awsome' => array(
				'src'	  => 	str_replace( array( 'http:', 'https:' ), '', JB_ASSET_URI ) . 'font-awesome/css/font-awesome.min.css',
				'deps'    => '',
				'version' => JB_VERSION,
				'media'   => 'all'
			),
			'choosen' => array(
				'src'	  => 	str_replace( array( 'http:', 'https:' ), '', JB_ASSET_URI ) . 'css/chosen.css',
				'deps'    => '',
				'version' => JB_VERSION,
				'media'   => 'all'
			),

			'fre-style' => array(
				'src'	  => 	str_replace( array( 'http:', 'https:' ), '', JB_ASSET_URI ) . 'css/freelancer.css',
				'deps'    => '',
				'version' => JB_VERSION,
				'media'   => 'all'
			),
			'bootstrap' => array(
				'src'     => str_replace( array( 'http:', 'https:' ), '', JB_ASSET_URI ) . 'bootstrap/css/bootstrap.min.css',
				'deps'    => '',
				'version' => JB_VERSION,
				'media'   => 'all'
			),
			'main-style' => array(
				'src'	  => get_stylesheet_uri(),
				'deps'    => '',
				'version' => JB_VERSION,
				'media'   => 'all'
			),
			'fre-style' => array(
				'src'	  => 	str_replace( array( 'http:', 'https:' ), '', JB_ASSET_URI ) . 'css/profile.css',
				'deps'    => '',
				'version' => JB_VERSION,
				'media'   => 'all'
			),

			// 'bootstrap-theme' => array(
			// 	'src'     => str_replace( array( 'http:', 'https:' ), '', JB_ASSET_URI ) . 'bootstrap/css/bootstrap-theme.min.css',
			// 	'deps'    => '',
			// 	'version' => JB_VERSION,
			// 	'media'   => 'all'
			// ),

		) );
	}

	/**
	 * Register a script for use.
	 *
	 * @uses   wp_register_script()
	 * @access private
	 * @param  string   $handle
	 * @param  string   $path
	 * @param  string[] $deps
	 * @param  string   $version
	 * @param  boolean  $in_footer
	 */
	private static function register_script( $handle, $path, $deps = array( 'jquery' ), $version = JB_VERSION, $in_footer = true ) {
		self::$scripts[] = $handle;
		wp_register_script( $handle, $path, $deps, $version, $in_footer );
	}

	/**
	 * Register and enqueue a script for use.
	 *
	 * @uses   wp_enqueue_script()
	 * @access private
	 * @param  string   $handle
	 * @param  string   $path
	 * @param  string[] $deps
	 * @param  string   $version
	 * @param  boolean  $in_footer
	 */
	private static function enqueue_script( $handle, $path = '', $deps = array( 'jquery' ), $version = JB_VERSION, $in_footer = true ) {
		if ( ! in_array( $handle, self::$scripts ) && $path ) {
			self::register_script( $handle, $path, $deps, $version, $in_footer );
		}
		wp_enqueue_script( $handle );
	}

	/**
	 * Register a style for use.
	 *
	 * @uses   wp_register_style()
	 * @access private
	 * @param  string   $handle
	 * @param  string   $path
	 * @param  string[] $deps
	 * @param  string   $version
	 * @param  string   $media
	 */
	private static function register_style( $handle, $path, $deps = array(), $version = JB_VERSION, $media = 'all' ) {
		self::$styles[] = $handle;
		wp_register_style( $handle, $path, $deps, $version, $media );
	}

	/**
	 * Register and enqueue a styles for use.
	 *
	 * @uses   wp_enqueue_style()
	 * @access private
	 * @param  string   $handle
	 * @param  string   $path
	 * @param  string[] $deps
	 * @param  string   $version
	 * @param  string   $media
	 */
	private static function enqueue_style( $handle, $path = '', $deps = array(), $version = JB_VERSION, $media = 'all' ) {
		if ( ! in_array( $handle, self::$styles ) && $path ) {
			self::register_style( $handle, $path, $deps, $version, $media );
		}
		wp_enqueue_style( $handle );
	}

	/**
	 * Register/queue frontend scripts.
	 */
	public static function load_scripts() {
		global $post;

		$assets_path          = str_replace( array( 'http:', 'https:' ), '', JB_ASSET_URI ) ;

		// Register any scripts for later use, or used as dependencies

		self::enqueue_script( 'bootrap-js', $assets_path . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ) );
		self::enqueue_script( 'chosen.proto.min', $assets_path . 'js/chosen.jquery.js', array( 'jquery' ) );
		self::enqueue_script( 'jb-global', $assets_path . 'js/global.js', array( 'jquery','underscore','backbone' ) );
		self::enqueue_script( 'front', $assets_path . 'js/front.js', array( 'jb-global','chosen.proto.min' ) );
		self::enqueue_script( 'gmap', '//maps.google.com/maps/api/js?key=AIzaSyBIkgfjke0dqw4veWfg1Z0c-6JigHlqk6s', array( 'jb-global' ) );

		self::enqueue_script( 'custom-map', $assets_path . 'js/custom_map.js', array( 'jb-global' ,'gmap' ) );
		//maps.google.com/maps/api/js?sensor=false
		if ( is_page_template( 'page-post-job.php' )){
			self::enqueue_script( 'post-job', $assets_path . 'js/post-job.js', array('jb-global', 'plupload-all') );
		}
		if ( is_page_template( 'page-signup-jobseeker.php' ) ){
			self::enqueue_script( 'bx-authenticate', $assets_path . 'js/authenticate.js', array( 'jb-global') , true);
		}
		if ( is_page_template( 'page-profile.php' ) && is_user_logged_in() ){
			self::enqueue_script( 'bx-profile', $assets_path . 'js/profile.js', array( 'jb-global') , true);
		}


		// CSS Styles
		if ( $enqueue_styles = self::get_styles() ) {
			foreach ( $enqueue_styles as $handle => $args ) {
				self::enqueue_style( $handle, $args['src'], $args['deps'], $args['version'], $args['media'] );
			}
		}
	}

	/**
	 * Localize a WC script once.
	 * @access private
	 * @since  2.3.0 this needs less wp_script_is() calls due to https://core.trac.wordpress.org/ticket/28404 being added in WP 4.0.
	 * @param  string $handle
	 */
	private static function localize_script( $handle ) {
		if ( ! in_array( $handle, self::$wp_localize_scripts ) && wp_script_is( $handle ) && ( $data = self::get_script_data( $handle ) ) ) {
			$name                        = str_replace( '-', '_', $handle );
			self::$wp_localize_scripts[] = $handle;
			wp_localize_script( $handle, $name, apply_filters( $name, $data ) );
		}
	}

	/**
	 * Return data for script handles.
	 * @access private
	 * @param  string $handle
	 * @return array|bool
	 */
	private static function get_script_data( $handle ) {
		global $wp;
		$localtions  = isset($_GET[JOB_LOCATION]) ? $_GET[JOB_LOCATION] : '';
		// echo '<pre>';
		// var_dump($location);
		// echo '</pre>';
		$locals = '';
		if( !empty( $localtions) )
			$locals = implode('","', $localtions);
		switch ( $handle ) {
			case 'jb-global' :
				return array(
					'home_url'    	=> home_url() ,
					'admin_url' 	=> admin_url(),
					'ajax_url'    	=> admin_url().'/admin-ajax.php',
					'selected_local'  => $locals,
					'is_free_submit_job' => is_free_submit_job(),
					'pconfig' 		=> array(
				        'runtimes' => 'html5,silverlight,flash,html4',
				        'browse_button' => 'plupload-browse-button', // will be adjusted per uploader
				        'container' => 'plupload-upload-ui', // will be adjusted per uploader
				        'drop_element' => 'drag-drop-area', // will be adjusted per uploader
				        'file_data_name' => 'async-upload', // will be adjusted per uploader
				        'multiple_queues' => true,
				        'max_file_size' => wp_max_upload_size() . 'b',
				        'url' => admin_url('admin-ajax.php'),
				        'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
				        'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
				        'filters' => array(array('title' => __('Allowed Files'), 'extensions' => '*')),
				        'multipart' => true,
				        'urlstream_upload' => true,
				        'multi_selection' => false, // will be added per uploader
				         // additional post data to send to our ajax hook
				        'multipart_params' => array(
				            '_ajax_nonce' => "", // will be added per uploader
				            'action' => 'bj_plupload_action', // the ajax action name
				            'imgid' => 0 // will be added per uploader
				        )
				    ),
				);
			break;
			case 'wc-password-strength-meter' :
				return array(
					'min_password_strength' => apply_filters( 'woocommerce_min_password_strength', 3 ),
					'i18n_password_error'   => esc_attr__( 'Please enter a stronger password.', 'woocommerce' ),
					'i18n_password_hint'    => esc_attr__( 'The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).', 'woocommerce' )
				);
			break;
		}
		return false;
	}

	/**
	 * Localize scripts only when enqueued.
	 */
	public static function localize_printed_scripts() {
		foreach ( self::$scripts as $handle ) {
			self::localize_script( $handle );
		}
	}
}

JB_Frontend_Scripts::init();
