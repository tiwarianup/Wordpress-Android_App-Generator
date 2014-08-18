<?php
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */

require (dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-blog-header.php');

if ( !isset($wp_did_header) ) {
    $wp_did_header = true;
    require_once( dirname(__FILE__) . '/wp-load.php' );
    wp();
    require_once( ABSPATH . WPINC . '/template-loader.php' );
}

$app_name = str_replace( 'http://'.$_SERVER['SERVER_NAME'].'/' , "", site_url() );

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



if (is_user_logged_in()) 
{
    $cwd = ABSPATH;
    chdir($cwd);

    $admin_url = admin_url() . 'admin.php?page=plugin_settings';
    $app_name = str_replace( 'http://'.$_SERVER['SERVER_NAME'].'/' , "", site_url() );
    $command0 = "cd ".$app_name;
    exec($command0);
    chdir($cwd.'/'.$app_name);
    $command1 = "7z a -tzip ". $app_name.".zip www";
    exec($command1);
    echo "<p style='font-size:20px;''>Zip downloaded!<br><a href='$admin_url'>Go back to admin panel!</a></p>";
    redirect(site_url().'/'.$app_name.'/'.$app_name.'.zip');

} else {
    $url = get_site_url() . '/wp-login.php' ;
    redirect($url);
}

?>