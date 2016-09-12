<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

    get_header(); ?>
	<div class="container">
        <div class="row ">
            <div class="col-md-8 content">
                <?php   the_post(); ?>
                <h1><?php  the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
            <?php get_sidebar(); ?>

    	</div>
    </div>

<?php get_footer();