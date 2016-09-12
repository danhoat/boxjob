<?php
class bj_user{
	function __construct(){

	}
	public static function add_role(){
		$roles_set = get_option('jobseeker_role_is_set');
	    if(!$roles_set){
	        add_role(JOBSEEKER, 'JOBSEEKER', array(
	            'read' => true,
	            'edit_posts' => false,
	            'delete_posts' => false,
	            'upload_files' => true
	        ));
	        update_option('jobseeker_role_is_set',true);
	    }
	    $roles_set = get_option('employer_role_is_set');
	    if(!$roles_set){
	        add_role( EMPLOYER, EMPLOYER, array(
	            'read' => true,
	            'edit_posts' => true,
	            'delete_posts' => true,
	            'upload_files' => true
	        ));
	        update_option('employer_role_is_set',true);
	    }
	}
	function sync($args,$method){
		switch ($method) {
			case 'created':
				return $this->insert_user($args);
				break;
			default:
				# code...
				break;
		}
	}
	function insert_user($args){

		$role = isset($args['role']) ? $args['role'] : '';
		if( empty($role) || !in_array( $role, array(EMPLOYER,JOBSEEKER) ) )
			$request['role'] = JOBSEEKER;

		return wp_insert_user($args);

	}
}
?>