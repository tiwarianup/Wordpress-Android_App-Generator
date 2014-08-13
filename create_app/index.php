<?php

define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */

require (dirname(dirname(dirname(__FILE__))).'/wp-blog-header.php');

if ( !isset($wp_did_header) ) {
    $wp_did_header = true;
    require_once( dirname(__FILE__) . '/wp-load.php' );
    wp();
    require_once( ABSPATH . WPINC . '/template-loader.php' );
}

mkdir(ABSPATH.'/Applications');

$cwd = ABSPATH . '/Applications';
chdir($cwd);

	$app_name = str_replace( 'http://'.$_SERVER['SERVER_NAME'].'/' , "", site_url() );
	$command1 = "cordova create ".$app_name;
	exec($command1);
	$command2 = "cd ".$app_name;
	exec($command2);
	$command3 = "cordova platform add android";
	exec($command3);


$string = '<div><p>Congratulations! Application directory has been created!<br>Now generate HTML pages for your website.</p><br><a href='.get_admin_url().">Back to admin panel</a></div>";

echo $string;

?>
