<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Post Types
 *
 * Registers post types and taxonomies.
 *
 * @class     JB_Post_types
 * @version   1.0
 * @category  Class
 * @author    boxtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Post_types Class.
 */
class JB_Post_types {

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 6 );
		//add_action( 'init', array( __CLASS__, 'support_jetpack_omnisearch' ) );
		//add_filter( 'rest_api_allowed_post_types', array( __CLASS__, 'rest_api_allowed_post_types' ) );
	}

	/**
	 * Register core post types.
	 */
	public static function register_post_types() {
		if ( post_type_exists('job') ) {
			return;
		}

		/*
		Register post_type order
		 */
		$labels  = array(
			'name'                  => __( 'Job', 'boxtheme' ),
			'singular_name'         => __( 'Job', 'boxtheme' ),
			'menu_name'             => _x( 'Jobs', 'Admin menu name', 'boxtheme' ),
			'add_new'               => __( 'Add Job', 'boxtheme' ),
			'add_new_item'          => __( 'Add New Job', 'boxtheme' ),
			'edit'                  => __( 'Edit', 'boxtheme' ),
			'edit_item'             => __( 'Edit Job', 'boxtheme' ),
			'new_item'              => __( 'New Job', 'boxtheme' ),
			'view'                  => __( 'View Job', 'boxtheme' ),
			'view_item'             => __( 'View Job', 'boxtheme' ),
			'search_items'          => __( 'Search Jobs', 'boxtheme' ),
			'not_found'             => __( 'No Jobs found', 'boxtheme' ),
			'not_found_in_trash'    => __( 'No Jobs found in trash', 'boxtheme' ),
			'parent'                => __( 'Parent Job', 'boxtheme' ),
			'featured_image'        => __( 'Featured Image', 'boxtheme' ),
			'set_featured_image'    => __( 'Set Job image', 'boxtheme' ),
			'remove_featured_image' => __( 'Remove Job image', 'boxtheme' ),
			'use_featured_image'    => __( 'Use as Job image', 'boxtheme' ),
			'insert_into_item'      => __( 'Insert into Job', 'boxtheme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Job', 'boxtheme' ),
			'filter_items_list'     => __( 'Filter Jobs', 'boxtheme' ),
			'items_list_navigation' => __( 'Job navigation', 'boxtheme' ),
			'items_list'            => __( 'Job list', 'boxtheme', 'boxtheme' ),
		);
	 	$args = apply_filters( 'bx_job_post_type', array(
	 		'labels' => $labels,
	 		'description'         => __( 'This is where you can add new Jobs.', 'boxtheme' ),
	      	'public' => true,
	      	'label'  => 'Jobs',
	      	'capability_type' => 'post',
			'show_ui'             => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
			'rewrite'             => array( 'slug' => 'job' ),
			'query_var'           => true,
			'supports'            => array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
			'has_archive'         => 'jobs',
			'show_in_nav_menus'   => true,
	    ));
	 	register_post_type( 'job', $args );

		if ( post_type_exists('order') ) {
			return;
		}
		/*
		Register post_type order
		 */
	 	$args = array(
	      	'public' => true,
	      	'label'  => 'Orders',
	      	'capability_type' => 'post',
	      	'description'         => __( 'This is where you can add new order.', 'boxtheme' ),
	      	'public' => true,
	      	'capability_type' => 'post',

			'show_ui'             => true,
			'capability_type'     => 'post',
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
			'query_var'           => false,
			'supports'            => array( 'title', 'editor', 'author', 'excerpt', 'custom-fields'),
			'show_in_nav_menus'   => true
	    );
	 	register_post_type( 'order', $args );

		/*
		End post_type order
		*/
		/*
		Register profile order
		 */
		$labels  = array(
			'name'                  => __( 'Profile', 'boxtheme' ),
			'singular_name'         => __( 'Profile', 'boxtheme' ),
			'menu_name'             => _x( 'Profiles', 'Admin menu name', 'boxtheme' ),
			'add_new'               => __( 'Add Profile', 'boxtheme' ),
			'add_new_item'          => __( 'Add New Profile', 'boxtheme' ),
			'edit'                  => __( 'Edit', 'boxtheme' ),
			'edit_item'             => __( 'Edit Profile', 'boxtheme' ),
			'new_item'              => __( 'New Profile', 'boxtheme' ),
			'view'                  => __( 'View Profile', 'boxtheme' ),
			'view_item'             => __( 'View Profile', 'boxtheme' ),
			'search_items'          => __( 'Search Profiles', 'boxtheme' ),
			'not_found'             => __( 'No Profiles found', 'boxtheme' ),
			'not_found_in_trash'    => __( 'No Profiles found in trash', 'boxtheme' ),
			'parent'                => __( 'Parent Profile', 'boxtheme' ),
			'featured_image'        => __( 'Featured Image', 'boxtheme' ),
			'set_featured_image'    => __( 'Set Profile image', 'boxtheme' ),
			'remove_featured_image' => __( 'Remove Profile image', 'boxtheme' ),
			'use_featured_image'    => __( 'Use as Profile image', 'boxtheme' ),
			'insert_into_item'      => __( 'Insert into Profile', 'boxtheme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Job', 'boxtheme' ),
			'filter_items_list'     => __( 'Filter Jobs', 'boxtheme' ),
			'items_list_navigation' => __( 'Profile navigation', 'boxtheme' ),
			'items_list'            => __( 'Profile list', 'boxtheme', 'boxtheme' ),
		);
	 	$args = apply_filters( 'bx_profile_post_type',array(
	 		'labels' => $labels,
	 		'description'         => __( 'This is where you can add new profiles.', 'boxtheme' ),
	      	'public' => true,
	      	'label'  => 'Profiles',
	      	'capability_type' => 'post',
			'show_ui'             => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
			'rewrite'             => array( 'slug' => 'profile' ),
			'query_var'           => true,
			'supports'            => array( 'title', 'editor', 'author', 'excerpt', 'custom-fields'),
			'has_archive'         => 'profiles',
			'show_in_nav_menus'   => true
	    ));
	 	register_post_type( 'profile', $args );

 		$args = array(
      	'public' => true,
      	'label'  => 'Testimonial',
      	'capability_type' => 'post',
      	'description'         => __( 'This is where you can add new testimonial.', 'boxtheme' ),
      	'public' => true,
      	'capability_type' => 'post',

			'show_ui'             => true,
			'capability_type'     => 'post',
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
			'query_var'           => false,
			'supports'            => array( 'title', 'editor', 'author', 'excerpt', 'custom-fields'),
			'show_in_nav_menus'   => true
	    );
	 	register_post_type( 'testimonial', $args );

	}
	/**
	 * Register core taxonomies.
	 */
	public static function register_taxonomies() {
		if ( taxonomy_exists( 'job_cat' ) ) {
			return;
		}
		register_taxonomy( 'job_cat',
			apply_filters( 'boxtheme_taxonomy_objects_job_cat', array( 'job' ) ),
			apply_filters( 'boxtheme_taxonomy_args_job_cat', array(
				'hierarchical'          => true,
				//'update_count_callback' => '_jb_term_recount',
				'label'                 => __( 'Job Categories', 'boxtheme' ),
				'labels' => array(
						'name'              => __( 'Product Categories', 'boxtheme' ),
						'singular_name'     => __( 'Product Category', 'boxtheme' ),
						'menu_name'         => _x( 'Categories', 'Admin menu name', 'boxtheme' ),
						'search_items'      => __( 'Search Job Categories', 'boxtheme' ),
						'all_items'         => __( 'All Job Categories', 'boxtheme' ),
						'parent_item'       => __( 'Parent Job Category', 'boxtheme' ),
						'parent_item_colon' => __( 'Parent Job Category:', 'boxtheme' ),
						'edit_item'         => __( 'Edit Job Category', 'boxtheme' ),
						'update_item'       => __( 'Update Job Category', 'boxtheme' ),
						'add_new_item'      => __( 'Add New Job Category', 'boxtheme' ),
						'new_item_name'     => __( 'New Job Category Name', 'boxtheme' ),
						'not_found'         => __( 'No Job Category found', 'boxtheme' ),
					),
				'show_ui'               => true,
				'query_var'             => true,
				// 'capabilities'          => array(
				// 	'manage_terms' => 'manage_job_terms',
				// 	'edit_terms'   => 'edit_job_terms',
				// 	'delete_terms' => 'delete_job_terms',
				// 	'assign_terms' => 'assign_job_terms',
				// ),
				'rewrite'               => array(
					'slug'         => 'job_cat',
					'with_front'   => false,
					'hierarchical' => true,
				),
			) )
		);
		register_taxonomy( 'location', 'job',
			array(
				'hierarchical'          => true,
				//'update_count_callback' => '_jb_term_recount',
				'label'                 => __( 'Job Locations', 'boxtheme' ),
				'labels' => array(
						'name'              => __( 'Job Locations', 'boxtheme' ),
						'singular_name'     => __( 'Job Location', 'boxtheme' ),
						'menu_name'         => _x( 'Locations', 'Admin menu name', 'boxtheme' ),
						'search_items'      => __( 'Search Job Locations', 'boxtheme' ),
						'all_items'         => __( 'All Job Locations', 'boxtheme' ),
						'parent_item'       => __( 'Parent Job Location', 'boxtheme' ),
						'parent_item_colon' => __( 'Parent Job Location', 'boxtheme' ),
						'edit_item'         => __( 'Edit Job Location', 'boxtheme' ),
						'update_item'       => __( 'Update Job Location', 'boxtheme' ),
						'add_new_item'      => __( 'Add New Job Location', 'boxtheme' ),
						'new_item_name'     => __( 'New Job Location Name', 'boxtheme' ),
						'not_found'         => __( 'No Job Location found', 'boxtheme' ),
					),
				'show_ui'               => true,
				'query_var'             => true,
				// 'capabilities'          => array(
				// 	'manage_terms' => 'manage_job_terms',
				// 	'edit_terms'   => 'edit_job_terms',
				// 	'delete_terms' => 'delete_job_terms',
				// 	'assign_terms' => 'assign_job_terms',
				// ),
				'rewrite'               => array(
					'slug'         => 'location',
					'with_front'   => false,
					'hierarchical' => true,
				),
			)
		);
		register_taxonomy( 'type', 'job',
			array (
				'hierarchical'          => true,
				'label'                 => __( 'Job Types', 'boxtheme' ),
				'labels' => array(
						'name'              => __( 'Job Type', 'boxtheme' ),
						'singular_name'     => __( 'Job type', 'boxtheme' ),
						'menu_name'         => _x( 'Types', 'Admin menu name', 'boxtheme' ),
						'search_items'      => __( 'Search Job Type', 'boxtheme' ),
						'all_items'         => __( 'All Job Type', 'boxtheme' ),
						'parent_item'       => __( 'Parent Job Type', 'boxtheme' ),
						'parent_item_colon' => __( 'Parent Job Type', 'boxtheme' ),
						'edit_item'         => __( 'Edit Job Type', 'boxtheme' ),
						'update_item'       => __( 'Update Job Type', 'boxtheme' ),
						'add_new_item'      => __( 'Add New Job Type', 'boxtheme' ),
						'new_item_name'     => __( 'New Job Type Name', 'boxtheme' ),
						'not_found'         => __( 'No Job Type found', 'boxtheme' ),
					),
				'show_ui'               => true,
				'query_var'             => true,
				// 'capabilities'          => array(
				// 	'manage_terms' => 'manage_job_terms',
				// 	'edit_terms'   => 'edit_job_terms',
				// 	'delete_terms' => 'delete_job_terms',
				// 	'assign_terms' => 'assign_job_terms',
				// ),
				'rewrite'               => array(
					'slug'         => 'type',
					'with_front'   => false,
					'hierarchical' => true,
				),
			)
		);
		register_taxonomy( 'skill', 'profile',
			array(
				'hierarchical'          => true,
				//'update_count_callback' => '_jb_term_recount',
				'label'                 => __( 'Skill', 'boxtheme' ),
				'labels' => array(
						'name'              => __( 'Skills', 'boxtheme' ),
						'singular_name'     => __( 'JSkills', 'boxtheme' ),
						'menu_name'         => _x( 'Skills', 'Admin menu name', 'boxtheme' ),
						'search_items'      => __( 'Search Skills', 'boxtheme' ),
						'all_items'         => __( 'All Skills ', 'boxtheme' ),
						'parent_item'       => __( 'Parent Skill ', 'boxtheme' ),
						'parent_item_colon' => __( 'Parent Skills ', 'boxtheme' ),
						'edit_item'         => __( 'Edit Job ', 'boxtheme' ),
						'update_item'       => __( 'Update Skill ', 'boxtheme' ),
						'add_new_item'      => __( 'Add New Skill', 'boxtheme' ),
						'new_item_name'     => __( 'New Skill Name', 'boxtheme' ),
						'not_found'         => __( 'No Skill  found', 'boxtheme' ),
					),
				'show_ui'               => true,
				'query_var'             => true,
				// 'capabilities'          => array(
				// 	'manage_terms' => 'manage_job_terms',
				// 	'edit_terms'   => 'edit_job_terms',
				// 	'delete_terms' => 'delete_job_terms',
				// 	'assign_terms' => 'assign_job_terms',
				// ),
				'rewrite'               => array(
					'slug'         => 'skill',
					'with_front'   => true,
					'hierarchical' => true,
				),
			)
		);
	}
	/**
	 * add new post_status for custom post.
	 */
	public static function register_post_status() {

	}

	/**
	 * Add Job Support to Jetpack Omnisearch.
	 */
	public static function support_jetpack_omnisearch() {
		if ( class_exists( 'Jetpack_Omnisearch_Posts' ) ) {
			new Jetpack_Omnisearch_Posts( 'product' );
		}
	}

	/**
	 * Added Job for Jetpack related posts.
	 *
	 * @param  array $post_types
	 * @return array
	 */
	public static function rest_api_allowed_post_types( $post_types ) {
		$post_types[] = 'job';

		return $post_types;
	}
}

JB_Post_types::init();
