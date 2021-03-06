<?php
$output 		= $title = $wrap_class = $thumbnail = $show_button = $css = '';
$readmore_text 	= __('Read more', 'kingcomposer');
$image_size 	= 'full';
$wrp_el_classes = apply_filters( 'kc-el-class', $atts );

extract($atts);

$orderby 		= isset( $order_by ) ? $order_by : 'ID';
$order 			= isset( $order_list ) ? $order_list : 'ASC';

$post_type 		= 'testimonial';

$args = array(
	'post_type' 		=> $post_type,
	'posts_per_page' 	=> $number_post,
	'orderby'        	=> $orderby,
	'order' 				=> $order,
);


$the_query = new WP_Query( $args );

$element_attribute = array();

$el_classess = array(
	'kc-owl-post-carousel',
	'owl-carousel',
	'list-'. $post_type,
	$wrap_class
);

if( isset($atts['nav_style']) && $nav_style !='' ){
	$el_classess[] = 'owl-nav-' . $nav_style;
}

$owl_option = array(
	'items' 		=> $items_number,
	'speed' 		=> intval( $speed ),
	'navigation' 	=> $navigation,
	'pagination' 	=> $pagination,
	'autoheight' 	=> $auto_height,
	'autoplay' 		=> $auto_play
);

$owl_option = strtolower( json_encode( $owl_option ) );

$element_attribute[] = 'class="'. esc_attr( implode(' ', $el_classess) ) .'"';
$element_attribute[] = "data-owl-options='$owl_option'";

ob_start();

if ( $the_query->have_posts() ) {

	global $post;



	echo '<div '. implode(' ', $element_attribute) .' style ="height:398px; ">';

	while ( $the_query->have_posts() ) {

		$the_query->the_post();
		?>
		<div class="item list-item post-<?php echo esc_attr( $post->ID ); ?> testimonial-item">

			<div class="post-content">
				<center>

				<?php
				if ( has_post_thumbnail($post->ID) ) {
					echo '<div class="image">';
					echo get_the_post_thumbnail($post->ID, $image_size);
					echo '</div>';
				}
				?>
				<div class="in-post-content"> <i class="fa fa-quote-left" aria-hidden="true"></i><?php echo wp_trim_words( get_the_content(), 25, ' ...' ); ?></div>
				<?php  echo '<h3 class="title">'. get_the_title() .'</h3>'; ?>
				</center>

			</div>

		</div>
		<?php
	}

	echo '</div>';

} else {

	echo __('Carousel Post: No posts found', 'kingcomposer');

}

wp_reset_postdata();

$output = ob_get_clean();

echo '<div class="kc-carousel-post cs-tes '. esc_attr( implode(' ', $wrp_el_classes) ) .'">'. $output .'</div>';

kc_js_callback( 'kc_front.owl_slider' );
?>
