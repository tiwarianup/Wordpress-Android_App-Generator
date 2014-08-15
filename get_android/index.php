<?php

define('WP_USE_THEMES', true);
/** Loads the WordPress Environment and Template */
require (dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-blog-header.php');

if ( !isset($wp_did_header) ) 
{
    $wp_did_header = true;
    require_once( dirname(__FILE__) . '/wp-load.php' );
    wp();
    require_once( ABSPATH . WPINC . '/template-loader.php' );
}

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
        echo 'window.location.href="'. $url .'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='. $url .'" />';
        echo '</noscript>'; exit;
    }
}

if (is_user_logged_in()) {
    $cwd = ABSPATH;
    chdir($cwd);
    echo getcwd().'<br>';

        $app_name = str_replace( 'http://'.$_SERVER['SERVER_NAME'].'/' , "", site_url() );
        try 
        {
            $command2 = "cd ".$app_name;
            exec($command2);
            $command3 = "cordova platform add android";
            exec($command3);
            $command4 = "cordova build ";
            exec($command4); 
        } 
        catch (Exception $e) 
        {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        ######################################################
        ##  ----------------------------------------------  ##
        ##    $command2 = "cd ".$app_name;                  ##
        ##    exec($command2);                              ##
        ##    $command3 = "cordova platform add android";   ##
        ##    exec($command3);                              ##
        ##    $command4 = "cordova build";                  ##
        ##    exec($command4);                              ##
        ##  ----------------------------------------------  ##
        ######################################################

    $app_name = str_replace( 'http://' . $_SERVER['SERVER_NAME'] . '/' , "", site_url()) ;
    $url = get_site_url() . '/' . $app_name . "/platforms/android/ant-build/HelloCordova-debug.apk";
    redirect($url);

} else 
{
    $url = get_site_url() . '/wp-login.php' ;
    redirect($url);
}


//EOF