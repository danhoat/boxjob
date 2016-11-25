<?php
$output 		= $title = $wrap_class = $thumbnail = $show_button = $css = '';
$readmore_text 	= __('Read more', 'boxtheme');
$image_size 	= 'thumnail';
$wrp_el_classes = apply_filters( 'kc-el-class', $atts );

extract($atts);

$orderby 		= isset( $order_by ) ? $order_by : 'ID';
$order 			= isset( $order_list ) ? $order_list : 'ASC';

$post_type 		= 'post';

$args = array(
	'post_type' 		=> $post_type,
	'posts_per_page' 	=> $number_post,
	'orderby'        	=> $orderby,
	'order' 				=> $order,
);

$the_query = new WP_Query( $args );

$element_attribute = array();

$el_classess = array(
	'list-'. $post_type,
	'row',
	$wrap_class
);


$element_attribute[] = 'class="'. esc_attr( implode(' ', $el_classess) ) .'"';

ob_start();

if ( $the_query->have_posts() ) {

	global $post;



	echo '<div '. implode(' ', $element_attribute) .' >';
	echo '<h3><center>'.$title.'</center></h3>';
	while ( $the_query->have_posts() ) {

		$the_query->the_post();
		?>

			<div class="col-md-4">
				<?php
				if ( has_post_thumbnail($post->ID) ) {
					echo '<div class="image">';
					echo get_the_post_thumbnail($post->ID, $image_size);
					echo '</div>';
				}
				?>
				<?php  echo '<h5 class="title">'. get_the_title() .'</h5>'; ?>
				<div class="in-post-content"><?php echo wp_trim_words( get_the_content(), 25, ' ...' ); ?></div>

				<a class="" href="<?php echo get_permalink();?>"> <?php echo $readmore_text;?> </a>
			</div>

		<?php
	}

	echo '</div>';

} else {

	echo __('Recent Post: No posts found', 'kingcomposer');

}

wp_reset_postdata();

$output = ob_get_clean();

echo '<div class="kc-carousel-post cs-tes '. esc_attr( implode(' ', $wrp_el_classes) ) .'">'. $output .'</div>';

kc_js_callback( 'kc_front.owl_slider' );
?>
