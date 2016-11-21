<?php
    global $job;

    $job    = jb_convert_job($job);
    // echo '<pre>';
    // var_dump($job);
    // echo '</pre>';
    $class  = '';

    if ( $job->is_featured )
        $class.= ' job-listing-featured ';

    // echo "<li class='job-listing-item col-md-12 {$class}'>";
    // echo '<div class="job-listing-inline job-listing-thumbnail col-md-2">';
    // jb_job_listing_thumbnail( $job );
    // echo '</div>';

    // echo '<div  class="job-listing-inline col-md-7 job-listing-info">';
    //     echo '<h3 class="job-listing-title"><a href="'.get_permalink().'">'.$job->post_title.'</a></h3>';
    //     echo '<label>'.get_the_author().'</label>';

    // echo '</div>';
    // echo '<div class="job-listing-inline job-listing-location col-md-3">';
    // echo '<i class="fa fa-map-marker" aria-hidden="true"></i> '.jb_get_job_location( $job->ID );
    // echo '<br />';
    // echo jb_get_job_cat( $job->ID );
    // echo '</div>';
    // echo '</li>';

    echo '<div class="row job-item">';
        echo '<div class="col-md-1 job-listing-thumbnail">';
        jb_job_listing_thumbnail( $job );
        echo '</div>';
        echo '<div class="col-md-6 col-xs-6 job-listing-info ">';
            echo '<h5 class="job-listing-title"><a href="'.get_permalink().'">'.$job->post_title.'</a></h3>';
                echo '<div class="row-fluid">';
                    echo 'YoungWorld ... ';
                    echo 'YoungWorld ...';
                    echo 'YoungWorld ...';
                echo '</div>';
        echo '</div>';
        echo '<div class="col-md-5 col-xs-6 right">';
            echo '<div class="col-md-6 padding-zero">';
                echo '<i class="fa fa-map-marker" aria-hidden="true"></i> '.jb_get_job_location( $job->ID );
            echo '</div>';
            echo '<div class="col-md-6 aling-right">';
                echo '<button> Full time</button>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
?>