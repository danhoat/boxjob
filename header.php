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

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top1">
        <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo home_url();?>">BoxThemes</a>
            </div>
            <div class="navbar-collapse col-sm-offset-5" id="myNavbar">
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
                <ul class="nav navbar-nav navbar-right">
                    <?php if ( !is_user_logged_in() ): ?>
                    <li><a href="#"  data-toggle="modal" data-target="#modalLogin" class="btn-signin"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
                    <li><a href="<?php echo bx_get_static_link('signup');?>"><span class="glyphicon glyphicon-user "></span> <?php _e('Sign up','boxtheme');?></a></li>
                <?php else: ?>
                <?php
                    global $user_ID;
                    $user = get_userdata( $user_ID );
                ?>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <strong><?php _e('Account','boxtheme');?></strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-profile">
                        <li>
                            <div class="navbar-login">
                                <div class="row ">
                                    <div class="col-lg-4">
                                        <p class="text-center">
                                            <?php echo get_avatar($user_ID);?>
                                        </p>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="text-left"><strong><?php echo $user->user_login;?></strong></p>
                                        <p class="text-left small"><?php echo $user->user_email;?></p>
                                        <p class="text-left">
                                            <a href="<?php echo bx_get_static_link('profile');?>" class="btn btn-primary btn-block btn-sm"><?php _e('Profile','boxtheme');?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            <a href="<?php echo wp_logout_url( home_url() );?>" class="btn btn-danger btn-block btn-sign-out"><i class="fa fa-sign-out"></i><?php _e('Log out','boxtheme');?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                <?php endif;?>
              </ul>
            </div>
          </div>
           <!-- /.navbar-collapse -->
        <!-- /.container-fluid -->
    </nav>