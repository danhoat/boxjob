 <?php
/**
 * Template Name: Post Job
 * http://v4-alpha.getbootstrap.com/components/forms/
*/

?>

	<?php get_header(); ?>
 	<!-- List job !-->
    <div class="container">
        <div class="row">
            <div class="col-md-8 list-job post-job">
                <ul class="list-steps list-steps">
                <?php
                   global $i;
                   $i = 0;
                    $class = "";
                    if ( ! is_user_logged_in() ):
                        $i++;
                        get_template_part('template/post-job','step-1-login' );
                    else: $class ="active"; endif;
                    ?>
                    <li class="<?php echo $class;?> heading-step">
                        <div class="wizard-heading">
                            <?php $i = $i+1; echo $i;?>. <?php _e('Job detail','boxtheme');?>
                            <span class="icon-location"></span>
                        </div>
                        <div class="wizard-content">
                           <?php get_template_part('template/post-job','step-2' ); ?>
                           <!--  <button class="btn-green done" type="submit">Continue</button> -->
                        </div>
                    </li>
                    <?php
                    if( ! is_free_submit_job() ){
                        get_template_part('template/post-job','step-3' );
                    }
                    ?>

                </ul>


            </div> <!-- list-job !-->
           <?php get_sidebar(); ?>
        </div>
    </div>
    <!-- End List Job !-->
<?php get_footer(); ?>