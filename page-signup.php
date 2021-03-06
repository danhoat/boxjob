 <?php
/**
 * Template Name: Page Signup
*/
 get_header();

 ?>
 	<!-- List job !-->
    <div class="container">
        <div class="row m-lg-top m-xlg-bottom">
            <div class="col-md-12 m-lg-bottom">
                <hgroup class="text-center">
                    <h1 class="m-xs-top-bottom">Let's get started!</h1>
                    <h1 class="m-xs-top-bottom">First, tell us what you're looking for.</h1>
                </hgroup>
            </div>

            <div class="m-lg-bottom hidden-xs">&nbsp;</div>
            <div class="p-md-bottom visible-xs">&nbsp;</div>

            <div class="col-md-12 text-center">
                <div class="col-md-5">
                    <div class="text-muted">
                        <div><i class="glyphicon-xlg air-icon-client"></i></div>
                        <div class="o-user-type-selection">I want to hire a freelancer</div>
                    </div>
                    <p class="fs-sm m-lg-bottom">
                        Find, collaborate with,
                        <br>
                        and pay an expert.
                    </p>
                    <a class="btn btn-primary text-capitalize m-0" href="<?php echo bx_get_static_link('signup-employer'); ?>"><?php _e('Hire','boxtheme');?></a>
                </div>

                <div class="col-md-2 o-or-divider">OR</div>

                <div class="col-md-5">
                    <div class="text-muted">
                        <div><i class="glyphicon-xlg air-icon-freelancer"></i></div>
                        <div class="o-user-type-selection">I'm looking for online work</div>
                    </div>
                    <p class="fs-sm m-lg-bottom">
                        Find freelance projects and
                        <br>
                        grow your business.
                    </p>
                    <a class="btn btn-primary text-capitalize m-0" href="<?php echo bx_get_static_link('signup-jobseeker');?>">Work</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End List Job !-->
<?php get_footer(); ?>