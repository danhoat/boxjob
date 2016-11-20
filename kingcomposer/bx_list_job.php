<?php

$class = $css = '';
extract( $atts );
if(is_numeric($number_show))
	$number_show = 10;

$output = '';
$el_class = apply_filters( 'kc-el-class', $atts );
$el_class[] = 'kc_text_block';

if( $class != '' )$el_class[] = $class;
if( $css != '' )$el_class[] = $css;

$job_query = new WP_Query(
	array(
		'post_type' 	=>'job',
		'show_posts' 	=> $number_show,
		'order' 			=> $order,
	)
);
echo '<div class="'.esc_attr( implode(' ', $el_class) ).' job-listing row999">';
if ( $job_query->have_posts() ) {

	while ( $job_query->have_posts() ) {
		global $post, $job;
		$job_query->the_post();

		$job = $post;
		get_template_part('template/job','item' );
	}

	wp_reset_postdata();
} else {

	_e('List job is empty','boxtheme');
}

echo '</div>';
