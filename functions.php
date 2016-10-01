<?php
define( 'JOB_LOCATION', 'location');
define( 'JOB_TYPE', 'type');
define( 'JOB_CAT', 'job_cat');
define( 'JOBSEEKER' ,'jobseeker');
define( 'EMPLOYER' ,'employer');
//post_type
define('JOB_PT','job');
define('PROFILE_PT','profile');

final Class BoxThemes{

	public $version = 1.0;
	/**
	 * the single instance of  the class
	 * @var null
	 */
	protected static $_instance = null;
	/**
	 * init for the theme.
	 * @version 1.0
	 * @since   1.0
	 */
	function __construct(){

		$this->define_constants();
		$this->includes();
		$this->init_hooks();


	}
	/**
	 * create main instance for the class.
	 * 	Ensures only one instance of theme in the system.
	 * @version [version]
	 * @since   1.0
	 * @author danng
	 * @return  new class
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function includes(){

		include_once( get_template_directory().'/includes/class-jb-user.php');
		include_once( get_template_directory().'/includes/class-jb-post-types.php');
		include_once( get_template_directory().'/includes/class-job.php');
		include_once( get_template_directory().'/includes/class-install.php');
		include_once( get_template_directory().'/includes/social/facebook.php');
		include_once( get_template_directory().'/includes/class-jb-profile.php');
		include_once( get_template_directory().'/includes/template.php' );

		include_once( get_template_directory().'/includes/themes.php' );
		include_once(get_template_directory() .'/includes/payments/config.php');
		if ( $this->is_request( 'frontend' ) ) {
			$this->frontend_includes();
		}
	}
	/**
	 * defile all constants of the theme on this method.
	 * @version [version]
	 * @since   1.0
	 * @author danng
	 * @return  [type]    [description]
	 */
	function define_constants(){
		define( 'JB_VERSION', $this->version );
		define( 'JB_URI', get_template_directory_uri() );
		define( 'JB_ASSET_URI', get_template_directory_uri().'/assets/' );

	}

	private function init_hooks() {
		//register_activation_hook( __FILE__, array( 'WC_Install', 'install' ) );
		add_action( 'after_setup_theme', array( $this, 'setup_environment' ) );
		//add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );
		//add_action( 'init', array( $this, 'init' ), 0 );
		// add_action( 'init', array( 'WC_Shortcodes', 'init' ) );
		// add_action( 'init', array( 'WC_Emails', 'init_transactional_emails' ) );
		add_action( 'wp_head', array( $this,'jb_head'));
		add_action( 'template_include', array( $this, 'bj_custom_search_template') );

	}
	/**
	 * setup global enviroment
	 * @version [version]
	 * @since   1.0
	 * @author danng
	 * @return  [type]    [description]
	 */
	public function setup_environment() {
		bj_user::add_role();
		$this->add_thumbnail_support();
		register_nav_menu( 'main_menu', __( 'Header Menu', 'boxtheme' ) );
		//$this->add_image_sizes();
	}
	function jb_head(){
		jb_custom_fonts();
	}
	function bj_custom_search_template($template){
		return $template;
	}
	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * enable post thumbnail support .
	 */
	private function add_thumbnail_support() {
		if ( ! current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}
		add_theme_support( 'menus' );

		add_post_type_support( 'job', 'thumbnail' );
	}

	function frontend_includes(){
		include_once( 'includes/class-jb-frontend-scripts.php' );
		include_once( 'includes/class-wp-ajax.php' );

	}


	/**
	 * reset memory.
	 * @version [version]
	 * @since   1.0
	 * @author danng
	 */
	function __destruct(){

	}
}

BoxThemes::instance();

function add_theme_caps(){
  global $pagenow;

  // gets the author role
  $role = get_role( 'author' );

  if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ){ // Test if theme is activated
    // Theme is activated

    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    $role->add_cap( 'edit_tes_posts' );
  }
  else {
    // Theme is deactivated
    // Remove the capacity when theme is deactivated
    $role->remove_cap( 'edit_others_posts' );
  }
}
add_action( 'load-themes.php', 'add_theme_caps' );


?>