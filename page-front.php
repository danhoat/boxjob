<?php
/**
 * Template Name: Front page
 *

/**
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
 * @subpackage Twenty_Fourteen
 * @since boxtheme 1.0
 */
?>
<?php get_header(); ?>
   <div class="bg-top-blur">
   </div>
<?php get_template_part( 'template/search', 'form' ); ?>
<?php //get_template_part( 'template/head', 'line' ); ?>
<?php //get_template_part( 'template/head', 'line' ); ?>
<div class="container-fluid bg-white no-padding" style="background-color: #fff;">
<?php
the_post();
the_content();
?>
</div>


<?php get_footer();?>