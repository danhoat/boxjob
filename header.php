<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage boxtheme
 * @since boxtheme 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="page-top" >
   <div class="bg-top-blur">
   </div>
   <div class="container-fluid" id="menu-line">
      <div class="container">
         <div class="row" >
            <div class="col-md-3">
               <a class="navbar-brand" href="<?php echo home_url();?>">BoxThemes</a>
            </div>
            <div class="navbar-collapse1 col-md-9" id="myNavbar">
                <div class="navbar-header">
                 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                 </button>
               </div>
               <nav class="navbar navbar-default navbar-fixed-top1 text-right">
                  <?php bx_user_dropdown_button();?>

                  <?php    /**
                   * Displays a navigation menu
                   * @param array $args Arguments
                   */
                   $args = array(
                       'theme_location' => 'main_menu',
                       'menu' => '',
                       'container' => '',
                       'menu_class' => 'menu',
                       'echo' => true,
                       'items_wrap' => '<ul id = "%1$s" class = "nav navbar-nav  %2$s">%3$s</ul>',
                   );
                   wp_nav_menu( $args );
                   ?>

               </nav> <!-- nav !-->
            </div>
         </div> <!-- row !-->
      </div> <!-- container !-->
   </div>
   <!-- /.navbar-collapse -->
<!-- /.container-fluid -->
