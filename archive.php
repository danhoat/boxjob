 <?php get_header(); ?>
 <!-- List job !-->
    <div class="container">
        <div class="row">
            <div class="col-md-8 list-job">
            <h2>Latest job </h2>
            <?php
            // $args = array(
            //     'post_type'     => 'job',
            //     'post_status'   => 'publish',
            //     'paged'         => max( 1, get_query_var('paged') ),
            // );
            // $jb_query = new WP_Query( $args );
            if( have_posts() ):

                echo '<ul class="job-listing">';
                while(have_posts() ):
                    the_post();
                    get_template_part('template/listing','job-item' );

                endwhile;
                echo '</ul>';

                jb_pagenate_links( );
            endif;
            ?>
            </div> <!-- list-job !-->
           <?php get_sidebar(); ?>
        </div>
    </div>
    <!-- End List Job !-->
<?php get_footer(); ?>