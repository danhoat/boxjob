<?php
/**
*
*	King Composer
*	(c) boxtheme.com
*
*/

if(!defined('KC_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$kc = kingcomposer::globe();
$mapper = get_option('kc_shortcodes_mapper', true);
$live_tmpl = KC_PATH.KDS.'shortcodes'.KDS.'live_editor'.KDS;

$kc->add_map(

	array(

		'_value' => array(
			'name' => 'KC Element',
			'description' => 'KC Element',
			'icon' => 'sl-info',	   /* Class name of icon show on "Add Elements" */
			'category' => '',	  /* Category to group elements when "Add Elements" */
			'is_container' => false, /* Container has begin + end [name]...[/name] -  Single has only [name param=""] */
			'pop_width' => 580,		/* width of the popup will be open when clicking on the edit  */
			'system_only' => true, /* Use for system only and dont show up to Add Elements */
			'params' => array()
		),
		'bx_list_job' => array(
			'name' => 'BX List job',
			'description' => __('A block of text with TINYMCE editor', 'boxtheme'),
			'icon' => 'kc-icon-text',
			'category' => 'Content',
			'is_container' => true,
			'pop_width' => 650,
			'admin_view'	=> 'text',
			'preview_editable' => true,
			'tab_icons' => array(
				'general' => 'et-tools',
				'styling' => 'et-adjustments',
				'animate' => 'et-lightbulb'
			),
			'live_editor' => $live_tmpl.'kc_column_text.php',
			'params' => array(


				'general' => array(
					array(
						'type'			=> 'text',
						'label'			=> __( 'Title', 'boxtheme' ),
						'name'			=> 'title',
						'description'	=> __( 'Title of Instagaram feed. Leave blank if no title is needed.', 'boxtheme' ),
						'admin_label'	=> true
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Number of photos', 'boxtheme' ),
						'name'			=> 'number_show',
						'description'	=> __( 'Set the number of job displayed.', 'boxtheme' ),
						'value'			=> '10',
						'admin_label'	=> true,
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Order by', 'boxtheme' ),
						'name'			=> 'field_oder',
						'value'     	=> 'date',
						'options'		=> array(
							'date' => __( 'Date', 'boxtheme' ),
							'featured' => __( 'Featured', 'boxtheme' ),
						),
						'description'	=> __( 'Direction of FlipBox', 'boxtheme' ),
					),
					array(
					'type'			=> 'dropdown',
						'label'			=> __( 'Order', 'boxtheme' ),
						'name'			=> 'order',
						'value'     	=> 'DESC',
						'options'		=> array(
							'DESC' => __( 'DESC', 'boxtheme' ),
							'ASC' => __( 'ASC', 'boxtheme' ),
						),
						'description'	=> __( 'Direction of FlipBox', 'boxtheme' ),
					),
					array(
						'name' => 'class',
						'label' => 'Extra Class',
						'type' => 'text',
					)
				),
				'styling' => array(
					array(
						'name'		=> 'css_custom',
						'type'		=> 'css',
						'options'	=> array(
							array(
								"screens" => "any,1024,999,767,479",
								'Typography' => array(
									array('property' => 'color', 'label' => 'Color', 'selector' => ',p'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => ',p'),
									array('property' => 'font-size', 'label' => 'Font Size', 'selector' => ',p'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => ',p'),
									array('property' => 'font-style', 'label' => 'Font Style', 'selector' => ',p'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => ',p'),
									array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => ',p'),
									array('property' => 'text-align', 'label' => 'Text Align', 'selector' => ',p'),
									array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => ',p'),
								),
								'Box'    => array(
									array('property' => 'background', 'label' => 'Background'),
									array('property' => 'border', 'label' => 'Border'),
									array('property' => 'border-radius', 'label' => 'Border Radius'),
									array('property' => 'padding', 'label' => 'Padding'),
									array('property' => 'margin', 'label' => 'Margin'),
								)
							)
						)
					)
				),
				'animate' => array(
					array(
						'name'    => 'animate',
						'type'    => 'animate'
					)
				),
			)
		),
		'cs_testimonial' => array(

			'name' => __('BoxTheme Testimonial ', 'boxtheme'),
			'description' => __('', 'boxtheme'),
			'icon' => 'kc-icon-pcarousel',
			'category' => 'Blog Posts',
			'css_box' => true,
			'is_container' => false,
			'tab_icons' => array(
				'general' => 'et-tools',
				'styling' => 'et-adjustments',
				'animate' => 'et-lightbulb'
			),
			'params' => array(
				'general' => array(
              array(
                  'name' => 'bg_url',
                  'label' => 'Upload Image',
                  'type' => 'attach_image_url',
                  'admin_label' => true,
                  'value' =>get_template_directory_uri().'/img/testimonial.jpg',
              	),
            	array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Order by', 'boxtheme' ),
						'name'			=> 'order_by',
						'description'	=> __( '', 'boxtheme' ),
						'admin_label'	=> true,
						'options' 		=> array(
							'ID'		=> __('Post ID', 'boxtheme'),
							'author'	=> __('Author', 'boxtheme'),
							'title'		=> __('Title', 'boxtheme'),
							'name'		=> __('Post name (post slug)', 'boxtheme'),
							'type'		=> __('Post type (available since Version 4.0)', 'boxtheme'),
							'date'		=> __('Date', 'boxtheme'),
							'modified'	=> __('Last modified date', 'boxtheme'),
							'rand'		=> __('Random order', 'boxtheme'),
							'comment_count'	=> __('Number of comments', 'boxtheme')
						)
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Order post', 'boxtheme' ),
						'name'			=> 'order_list',
						'description'	=> __( '', 'boxtheme' ),
						'admin_label'	=> true,
						'options' 		=> array(
							'ASC'		=> __('ASC', 'boxtheme'),
							'DESC'		=> __('DESC', 'boxtheme'),
						)
					),
					array(
						'type'			=> 'number_slider',
						'label'			=> __( 'Number of posts displayed', 'boxtheme' ),
						'name'			=> 'number_post',
						'description'	=> __( 'The number of posts you want to show.', 'boxtheme' ),
						'value'			=> '5',
						'admin_label'	=> true,
						'options' => array(
							'min' => 1,
							'max' => 20
						)
					),
					array(
						'type'			=> 'toggle',
						'label'			=> __( 'Show thumbnail', 'boxtheme' ),
						'name'			=> 'thumbnail',
						'description'	=> __( 'Show the post thumbnail.', 'boxtheme' ),
					),
					array(
						'type'			=> 'text',
						'label'			=> __( 'Image size', 'boxtheme' ),
						'name'			=> 'image_size',
						'description'	=> __( 'Set the image size : thumbnail, medium, large or full.', 'boxtheme' ),
						'value'			=> 'thumbnail',
						'relation' 	=> array(
							'parent'	=> 'thumbnail',
							'show_when'		=> 'yes'
						)
					),


					array(
						'type'			=> 'toggle',
						'label'			=> __( 'Navigation', 'boxtheme' ),
						'name'			=> 'navigation',
						'description'	=> __( 'Display the "Next" and "Prev" buttons.', 'boxtheme' ),
					),
					array(
						'type'        	=> 'dropdown',
						'label'     	=> __( 'Navigation Style', 'boxtheme' ),
						'name'  		=> 'nav_style',
						'description' 	=> __( 'Select how navigation buttons display on slide.', 'boxtheme' ),
						'options'       	=> array(
							'' => __( 'Buttons', 'boxtheme' ),
							'arrow' => __( 'Arrow', 'boxtheme' ),
							'round' => __( 'Rounded Arrow', 'boxtheme' )
						),
						'relation'  	=> array(
							'parent'	=> 'navigation',
							'show_when' => 'yes'
						)
					),
					array(
						'type'			=> 'toggle',
						'label'			=> __( 'Pagination', 'boxtheme' ),
						'name'			=> 'pagination',
						'description'	=> __( 'Show the pagination.', 'boxtheme' ),
						'value'			=> 'yes'
					),
					array(
						'type'			=> 'toggle',
						'label'			=> __( 'Auto height', 'boxtheme' ),
						'name'			=> 'auto_height',
						'description'	=> __( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'boxtheme' ),
					),
					array(
						'type'			=> 'toggle',
						'label'			=> __( 'Auto Play', 'boxtheme' ),
						'name'			=> 'auto_play',
						'description'	=> __( 'The carousel automatically plays when site loaded.', 'boxtheme' ),
						'value'			=> 'yes'
					),
					array(
						'type' => 'text',
						'label' => __( 'Wrapper class name', 'boxtheme' ),
						'name' => 'wrap_class',
						'description' => __( 'Custom class for wrapper of the shortcode widget.', 'boxtheme' )
					),
				),
				'styling' => array(
					array(
						'name'    => 'css_custom',
						'type'    => 'css'
					)
				),
			)
		),
	)

);


if ($mapper && is_array($mapper)) {
	$kc->add_map ($mapper);
}
add_filteR('kc-core-shortcode-filters','bx_add_enque_king_js');
function bx_add_enque_king_js($slug){
	array_push($slug,'cs_testimonial');

	return $slug;
}
function kc_cs_testimonial_filter( $atts = array() ){

	$atts = kc_remove_empty_code( $atts );
	extract( $atts );
	wp_enqueue_script( 'owl-carousel' );
	wp_enqueue_style( 'owl-theme' );
	wp_enqueue_style( 'owl-carousel' );

	return $atts;
}
add_action('wp_footer','cs_enqueue_script', 9999);
function cs_enqueue_script(){?>

<script type="text/javascript">
	(function($){
		$( document ).ready(function($){
			kc_front.owl_slider( '.cs-test' );
		});
	})(jQuery);

</script>
<?php }
add_filter( 'shortcode_cs_testimonial', 'kc_cs_testimonial_filter' );

?>
