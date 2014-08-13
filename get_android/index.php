<?php

define('WP_USE_THEMES', true);
/** Loads the WordPress Environment and Template */
require (dirname(dirname(dirname(__FILE__))).'/wp-blog-header.php');

if ( !isset($wp_did_header) ) 
{
    $wp_did_header = true;
    require_once( dirname(__FILE__) . '/wp-load.php' );
    wp();
    require_once( ABSPATH . WPINC . '/template-loader.php' );
}

$app_name = str_replace( 'http://' . $_SERVER['SERVER_NAME'] . '/' , "", site_url()) ;

function redirect($url)
{
    if (!headers_sent())
    {
        header('Location: '.$url);
        exit;
    }
    else
    {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}

// header( 'Location: ABSPATH . "/Applications/". $app_name . "platforms/android/ant-build/HelloWorld-debug.apk" ');

$url = get_site_url() . "/Applications/". $app_name . "/platforms/android/ant-build/HelloWorld-debug.apk";
redirect($url);

//EOF