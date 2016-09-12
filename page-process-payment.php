 <?php
/**
 * Template Name: Process payment
 * http://v4-alpha.getbootstrap.com/components/forms/
*/
$paypal = new JB_PayPal();
$paypal->handle_ipn_api_requests();
?>
	<?php get_header(); ?>
 	<!-- List job !-->
    <div class="container">
        <div class="row">
            <div class="col-md-8 list-job post-job">
            	<div class="content">
            		<?php
                        $job_id = isset($_POST['custom']) ? $_POST['custom'] :0;

            			if(  $job_id ){
                            $job      = get_post($job_id);
            				_e('Thank you, You have submmited job successfully','boxtheme');
                            echo '<br />';
                            printf( __('Job detail <a href="%s">%s</a>.'), get_permalink($job_id ), $job->post_title );
            			} else {
                            echo 'Nothing here';
                        }
            		?>
            	</div>
            </div> <!-- list-job !-->
           <?php get_sidebar(); ?>
        </div>
    </div>
    <!-- End List Job !-->
<?php get_footer(); ?>