
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

	$cwd = ABSPATH;
//	echo $cwd.'<br>';
	chdir($cwd);

	$app_name = str_replace( 'http://'.$_SERVER['SERVER_NAME'].'/' , "", site_url() );
//	echo $app_name.'<br>';

	$command1 = "cordova create ".$app_name;
//	var_dump($app_name);
//	echo $command1.'<br>';
	exec($command1);
//	var_dump($command1).'<br>';

	$command2 = "cd ".$app_name;
//	echo $command2.'<br>';
	exec($command2);

	$command3 = "cordova platform add android";
//	echo $command3.'<br>';
	exec($command3);

	$command4 = "cordova build";
	exec($command4);

	$string = '<html><head><title>Success! Application Directory created</title></head><body><div><p>Congratulations! Application directory has been created!<br>Now generate HTML pages for your website.</p><br><a href='.get_admin_url().">Back to admin panel</a></div></body></html>";

	echo $string;

?>
