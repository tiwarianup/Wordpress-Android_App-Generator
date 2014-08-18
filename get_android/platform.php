<?php
ini_set("max_execution_time", 0);

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

$admin_url = admin_url() . 'admin.php?page=plugin_settings';
echo "<p style='font-size:20px;'>Please wait as the android app is getting generated!";


if (is_user_logged_in()) 
{
    $cwd = ABSPATH;
    chdir($cwd);

    $app_name = str_replace( 'http://'.$_SERVER['SERVER_NAME'].'/' , "", site_url() );
    chdir($cwd . '/' . $app_name);
    $command2 = "cordova platform add android";
    $output1  = shell_exec($command2);
    exec($command2);
    $url = plugins_url() . '/phonegap-app-generator/get_android/build.php';
	redirect($url);
} else 
{
    $url = get_site_url() . '/wp-login.php' ;
    redirect($url);
}

?>

<!doctype html>
<head>
	<title>Platform addition | Phoneapp generator</title>
	<style type="text/css">
		body {
		    background-color: #aaa;
		    padding: 10px;
		}

		#progressbar {
		    width: 100%;
		    height: 15px;
		    background-color: #eee;
		    padding: 2px;
		    margin: .6em 0;
		    border: 1px #000 double;
		    clear: both;
		}

		#progress {
		    background: #A1C969; /*-- Color of the bar --*/
		    height: 15px;
		    width: 0%;
		    max-width: 100%;
		    float: left;
		    -webkit-animation: progress 2s 1 forwards;
		    -moz-animation: progress 2s 1 forwards;
		    -ms-animation: progress 2s 1 forwards;
		    animation: progress 2s 1 forwards;
		}

		#pbaranim {
		    height: 15px;
		    width: 100%;
		    overflow: hidden;
		    background: url('http://www.cssdeck.com/uploads/media/items/7/7uo1osj.gif') repeat-x;
		    -moz-opacity: 0.25;
		    -khtml-opacity: 0.25;
		    opacity: 0.25;
		    -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=25);
		    filter: progid:DXImageTransform.Microsoft.Alpha(opacity=25);
		    filter: alpha(opacity=25);
		}

		@-webkit-keyframes progress { 
		    from { }

		    to { width: 100% }
		}

		@-moz-keyframes progress { 
		    from { }

		    to { width: 100% }
		}

		@-ms-keyframes progress { 
		    from { }

		    to { width: 36% }
		}

		@keyframes progress { 
		    from { }

		    to { width: 36% }
		}
	</style>
</head>
<body>
	<div id="progressbar"><div id="progress" ><div id="pbaranim"></div></div></div>
</body>
</html>
