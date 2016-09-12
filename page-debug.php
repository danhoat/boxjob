<?php
/**
 * Template Name: Debug only
 *
 *
 **/
    echo '<pre>';
    echo '<br /> Return : <br />';
    $t = bx_get_static_link( 'signup-employer' );
    var_dump($t);
