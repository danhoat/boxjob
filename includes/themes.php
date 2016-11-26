<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if( !function_exists('bx_get_static_link')):

	function bx_get_static_link($page_args){

		$slug = $page_args;
		if( is_array($page_args) ){
			$slug = $page_args['page_template'];
		}
		$name = "page-{$slug}-link";
		$link = wp_cache_get($name, 'static_link');

		if ( false !== $link ) {
			return $link;
		}
		$page = get_pages( array(
			            'meta_key' 		=> '_wp_page_template',
			            'meta_value' 	=> 'page-' . $slug . '.php',
			            'numberposts' 	=> 1,
			            //'hierarchical' 	=> 0,
			        ));
		$id = 0;
		if( empty($page) ){
			$args  = array(
				'post_title' => $slug,
				'post_type' => 'page',
				'post_status' => 'publish',
			);
			$id = wp_insert_post($args);
			update_post_meta($id,'_wp_page_template','page-' . $slug . '.php' );
		} else {
			$page = array_shift($page);
	        $id = $page->ID;
		}
		$link = get_permalink($id);
		wp_cache_set( $name, $link, 'static_link');
	    return $link;
	}
endif;
	/**
	 * get location of job
	 * @return  string job_location name
	 */
	if( ! function_exists('jb_get_job_location')):

		function jb_get_job_location( $job_id ) {

			$terms = get_the_terms( $job_id, JOB_LOCATION );

			if ( $terms && ! is_wp_error( $terms ) ) :
				return '<a href="'.get_term_link($terms[0] ).'">'.$terms[0]->name.'</a>';
			endif;

			return '';
		}
	endif;

	if( ! function_exists('jb_get_job_type_string')):

		function jb_get_job_type_string( $job_id ) {

			$terms 		= get_the_terms( get_the_ID(), JOB_TYPE );
			$on_draught = "";

			if ( $terms && ! is_wp_error( $terms ) ) :

			    $draught_links = array();

			    foreach ( $terms as $term ) {
			        $draught_links[] = $term->name;
			    }

			    $on_draught = join( ", ", $draught_links );
			endif;

			return $on_draught;
		}
	endif;

	if( ! function_exists('jb_get_job_cat')):

		function jb_get_job_cat( $job_id ) {

			$terms 		= get_the_terms( get_the_ID(), JOB_CAT );
			$on_draught = "";

			if ( $terms && ! is_wp_error( $terms ) ) :

			    $draught_links = array();

			    foreach ( $terms as $term ) {
			        $draught_links[] = $term->name;
			    }

			    $on_draught = join( ", ", $draught_links );
			endif;

			return $on_draught;
		}
	endif;

	if( ! function_exists('jb_get_job_company_name')):

	function jb_get_job_company_name( $job_id ) {

		$job  = get_post($job_id);

		if( $job ):
			$author = $job->post_author;
		endif;

	}
	endif;

	if( ! function_exists('jb_convert_job')):

		function jb_convert_job( $post ) {

			$job = $post;
			$job->is_featured 	= get_post_meta($post->ID,'is_featured', true);
			$job->the_type  	= jb_get_job_type_string( $post->ID );

			return $job;

		}
	endif;


	if (  ! function_exists( 'jb_pagenate_links' )):

		/**
		 * paginaate the listing
		 * @version 1.0
		 * @since   1.0
		 * @author danng
		 * @return  void
		 */
		function jb_pagenate_links( $jb_query = false, $add_query = array() ){
			global $wp_query;
			if ( $jb_query )
				$wp_query = $jb_query;

	        $big = 999999999; // need an unlikely integer
	        $default = array(
	        	'type' 		=> 'list',
	            'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	            'format' 	=> '?paged=%#%',
	            'current' 	=> max( 1, get_query_var('paged') ),
	            'total' 	=> $wp_query->max_num_pages,
	        ) ;
	        if(!empty( $args)){
	        	$default['add_args'] = $add_query;
	        	$default['base'] = home_url('search');

	        }
	        $paginate = paginate_links( $default);

	        $paginate = str_replace('page-numbers', 'pagination', $paginate);

	        echo $paginate;
		}
	endif;

	if( !function_exists('jb_job_listing_thumbnail') ):
		/**
		 * display job featured image.
		 * @version 1.0
		 * @since   1.0
		 * @author 	danng
		 * @param   object    $job
		 * @return  void
		 */
		function jb_job_listing_thumbnail($job){

			if( has_post_thumbnail($job->ID) ):
	        	the_post_thumbnail( 'thumbnail', array('class' => 'alignleft', 'alt' => $job->post_title, 'title' => $job->post_title ) );
	        else :
	        	echo'<img srg="">';
	   		endif;
		}
	endif;
	if ( ! function_exists( 'jb_add_template' )):
		function jb_add_template(){
			if( ! is_user_logged_in() ) {
				get_template_part( 'template-js/modal','login' );
				//get_template_part( 'template-js/modal','login' );
			}
		}
	endif;
/**
 *  Allow admin select a google font for website.
 */
if ( ! function_exists( 'jb_custom_fonts')):
	function jb_custom_fonts($slug = ""){
		$static_url = "https://fonts.googleapis.com/css?family=";
		$fonts = array(
			'open_sans' => array(
				'title' 		=> "Open Sans",
				'font_family'	=> '', //"'Open Sans' ",
				'google_url' 	=> $static_url."Open+Sans:400italic",
			),
			'roboto' => array(
				'title' 		=> "Roboto",
				'font_family'	=> "'Roboto', sans-serif",
				'google_url' 	=> $static_url."Roboto",
			)
		);

		if(empty( $slug) ){ $slug ="open_sans"; }
		$font = $fonts[$slug];
		?>

		<link href='<?php echo $font['google_url'];?>' rel='stylesheet' type='text/css'>
		<style type ="text/css">
			body{
				font-family:<?php echo $font['font_family'];?>;
			}
		</style>
		<?php
		unset($fonts);
		unset($font);
	}
endif;
function is_job_has_order($job_id) {
	$has_order = get_post_meta($job_id, 'has_order', true);
	if($has_order)
		return true;
	return false;
}
function is_free_submit_job(){
	return true;
	return get_option( 'is_free_submit_job', false );
}
function is_pending_job(){
	return get_option( 'is_free_submit_job', false );
}
function is_admin_role(){
	return current_user_can( 'manage_options' );
}
/**
 * check user and auto login
 * @version [version]
 * @since   1.0
 * @author danng
 * @param   array    $info info of user will login.
 * @return  array
 */
function bx_signon($info){
	$creds 		= array();
	if(isset($info['user_pass']))
		$info['user_password'] = $info['user_pass'];

	$creds['user_login'] 	= $info['user_login'];
	$creds['user_password'] = $info['user_password'];
	$creds['remember'] 		= true;

	$response 	= array( 'success' => false, 'msg' => __('Login succesful','boxtheme') );

	$user = wp_signon( $creds, false );
	if ( ! is_wp_error( $user ) ){
		$response 	= array( 'success' => true, 'msg' => __('You have logged succesful','boxtheme') );
	} else  {
		$type_error = $user->get_error_codes()[0];
		//invalid_username,empty_username,empty_password,incorrect_password
		if ( in_array($type_error, array('empty_username') ) ){
			$msg = __('The username field is empty', 'boxtheme');
		} else	if ( in_array($type_error, array('empty_password') ) ){
			$msg = __('The password field is empty', 'boxtheme');
		} else if ( in_array( $type_error, array('invalid_username') ) ){
			$msg = __('Invalid username', 'boxtheme');
		}else if ( in_array($type_error, array('incorrect_password') ) ){
			$msg = sprints(__('The password you entered for the username %s is incorrect', 'boxtheme'));
		} else {
			$msg = strip_tags($user->get_error_message());
		}
		$response['msg'] 		= $msg;
		$response['success'] 	= false;
    }
	return $response;
}
add_filter( 'teeny_mce_buttons', 'bx_teeny_mce_buttons');
function bx_teeny_mce_buttons ($buttons) {
	return array('bold', 'italic', 'underline', 'bullist', 'numlist', 'link', 'unlink');
}
function bx_editor_settings() {
	return apply_filters( 'ce_ad_editor_settings', array(
		'quicktags'  => false,
		'media_buttons' => false,
		'textarea_rows' => 5,
		'wpautop'	=> false,
		//'tabindex'	=>	'2',
		'teeny'		=> true,
		'tinymce'   => array(
			'height'   => 150,
			'autoresize_min_height'=> 250,
			'autoresize_max_height'=> 550,
			'theme_advanced_buttons1' => 'bold,|,italic,|,underline,|,bullist,numlist,|,wp_fullscreen',
			'theme_advanced_buttons2' => '',
			'theme_advanced_buttons3' => '',
			'theme_advanced_statusbar_location' => 'none',
			'theme_advanced_resizing'	=> true ,
			'setup' =>  "function(ed){
				ed.onChange.add(function(ed, l) {
					var content	= ed.getContent();
					if(ed.isDirty() || content === '' ){
						ed.save();
						jQuery(ed.getElement()).blur(); // trigger change event for textarea
					}

				});

			}"
		)
	));
}
function get_profile_of_user($user_id){
	global $wpdb;
	$profile = $wpdb->get_row( "SELECT ID FROM $wpdb->posts WHERE post_author = $user_id AND post_type = '".PROFILE_PT."'" );

	return ($profile !== null) ? (int) $profile->ID : 0 ;
}
function bx_user_dropdown_button(){ ?>
	<ul class="nav navbar-nav navbar-right">
	    <?php if ( !is_user_logged_in() ){ ?>
	    <li><a href="#"  data-toggle="modal" data-target="#modalLogin" class="btn-signin"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
	    <li><a href="<?php echo bx_get_static_link('signup');?>"><span class="glyphicon glyphicon-user "></span> <?php _e('Sign up','boxtheme');?></a></li>
	<?php } else{ ?>
		<?php
	    global $user_ID;
	    $user = get_userdata( $user_ID );
		?>
	   <li class="dropdown">
		    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		        <span class="glyphicon glyphicon-user"></span> 
		        <strong><?php _e('Account','boxtheme');?></strong>
		        <span class="glyphicon glyphicon-chevron-down"></span>
		    </a>

			<ul class="dropdown-menu dropdown-profile">
				<li>
				   <div class="navbar-login">
				       <div class="row ">
				           <div class="col-lg-4">
				               <p class="text-center">
				                   <?php echo get_avatar($user_ID);?>
				               </p>
				           </div>
				           <div class="col-lg-8">
				               <p class="text-left"><strong><?php echo $user->user_login;?></strong></p>
				               <p class="text-left small"><?php echo $user->user_email;?></p>
				               <p class="text-left">
				                   <a href="<?php echo bx_get_static_link('profile');?>" class="btn btn-primary btn-block btn-sm"><?php _e('Profile','boxtheme');?></a>
				               </p>
				           </div>
				       </div>
				   </div>
				</li>
				<li class="divider"></li>
				<li>
				   <div class="navbar-login navbar-login-session">
				       <div class="row">
				           <div class="col-lg-12">
				               <p>
				                   <a href="<?php echo wp_logout_url( home_url() );?>" class="btn btn-danger btn-block btn-sign-out"><i class="fa fa-sign-out"></i><?php _e('Log out','boxtheme');?></a>
				               </p>
				           </div>
				       </div>
				   </div>
				</li>
			</ul>
		</li>

	<?php }; ?>
	</ul> <?php

}