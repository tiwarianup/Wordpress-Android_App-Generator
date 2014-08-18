<?php
ini_set("max_execution_time", 0);

define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */

require (dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-blog-header.php');

if ( !isset($wp_did_header) ) {
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


if ( is_user_logged_in() ) 
{
	$cwd = ABSPATH;
	chdir( $cwd );
	$admin_url = admin_url() . 'admin.php?page=plugin_settings';
	$app_name = str_replace( 'http://'.$_SERVER['SERVER_NAME'].'/' , "", site_url() );
	$command1 = "cordova create ".$app_name;
	exec( $command1 );
	$command2 = "cd ".$app_name;
	exec( $command2 );
	$command3 = "cordova platform add android";
	exec( $command3 );
	echo "<p style='font-size:20px;''>Application directory created.<br><a href='$admin_url'>Go back to admin panel!</a></p>";

}else
{
	$url = get_site_url() . '/wp-login.php' ;
	redirect($url);
}


/*
$cwd = ABSPATH;
chdir($cwd);

	$app_name = str_replace( 'http://'.$_SERVER['SERVER_NAME'].'/' , "", site_url() );
	$command1 = "cordova create ".$app_name;
	exec($command1);
	$command2 = "cd ".$app_name;
	exec($command2);
	$command3 = "cordova platform add android";
	exec($command3);
*/

// $string = '<div><p>Congratulations! Application directory has been created!<br>Now generate HTML pages for your website.</p><br><a href='.get_admin_url().">Back to admin panel</a></div>";

// echo $string;

?>
