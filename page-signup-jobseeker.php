 <?php
/**
 * Template Name: Page Jobseeker Signup
*/
?>
<?php get_header(); ?>

    <div class="container">
        <div class="row m-lg-top m-xlg-bottom">
            <div class="col-md-12 m-lg-bottom page-auth">
                <?php
                global $role;
                $role = JOBSEEKER;
                ?>
                <?php include(locate_template('template/signup-form.php')); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>