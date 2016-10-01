 <?php
/**
 * Template Name: Search template
*/
?>
	<?php get_header(); ?>
    <?php get_template_part( 'template/search', 'form' ); ?>

 	<!-- List job !-->
    <div class="container">
        <div class="row">
            <div class="col-md-8 list-job">
            <h2> Results</h2>
            <?php
            $add_query = array();
            $keyword    = get_query_var( 'keyword' );
            $cat        = isset($_GET['cat']) ? $_GET['cat'] : '';
            $location   = isset($_GET['loc']) ? $_GET['loc'] : '';

            $args = array(
                'post_type'     => 'job',
                'post_status'   => 'publish',
                's'             => $keyword ,
                'paged'         => max( 1, get_query_var('paged') ),
            );

            if( !empty( $location) ) {
                $args['tax_query'][] =   array(
                    'taxonomy' => 'location',
                    'field'    => 'slug',
                    'terms'    => $location,
                );
                $add_query['loc'] = $location;
            }

            if( !empty( $cat) && $cat != '0' ) {
                $args['tax_query'][] =   array(
                    'taxonomy' => 'job_cat',
                    'field'    => 'slug',
                    'terms'    => $cat,
                );
                $add_query['cat'] = $cat;
            }

            $jb_query = new WP_Query( $args );
            if( $jb_query->have_posts() ):

                echo '<ul class="job-listing">';
                while( $jb_query->have_posts() ):
                    $jb_query->the_post();
                    get_template_part('template/listing','job-item' );

                endwhile;
                echo '</ul>';

                global $wp_query;

                $wp_query = $jb_query;

                $big = 999999999; // need an unlikely integer
                $default = array(
                    'type'      => 'list',
                    'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'base'        => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format'    => '?paged=%#%',
                    'current'   => max( 1, get_query_var('paged') ),
                    'total'     => $wp_query->max_num_pages,
                ) ;
                $default['add_args'] = $add_query;
                $paginate = jb_pagenate_links( $jb_query);
                echo $paginate;
            else:
                _e('did not found post', 'boxtheme');
            endif;
            ?>
            </div> <!-- list-job !-->
           <?php get_sidebar(); ?>
        </div>
    </div>
    <!-- End List Job !-->
<?php get_footer(); ?>