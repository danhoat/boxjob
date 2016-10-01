<?php
/*
 * Template Name: Page profile
 * http://v4-alpha.getbootstrap.com/components/forms/
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Box_Job
 * @since boxtheme 1.0
 */
?>
    <?php get_header(); ?>
    <!-- List job !-->
    <div class="container">
        <div class="row">
            <div class="col-md-8 profile-container">

            	<div class="box border-success">
                    <?php
                    global $profile, $profile_id, $user_ID;
                    $profile_id = get_profile_of_user($user_ID);

                    $profile = get_post($profile_id);
                    ?>
                    <?php get_template_part( 'template/profile/summary' ); ?>
                    <?php get_template_part( 'template/profile/skill' ); ?>
                    <?php get_template_part( 'template/profile/emp-history' ); ?>
                </div>


            </div> <!-- list-job !-->
           <?php get_sidebar(); ?>
        </div>
    </div>


<?php get_footer();?>