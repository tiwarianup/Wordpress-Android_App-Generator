<?php
/**
 * @package Phonegap Application 
 * @version 1.0
 */
/*
Plugin Name: Phonegap application generator
	Plugin URI: http://#
	Description: Generate Phonegap Applications. Please ensure to enable disable-comments plugin if you don't want the comments to appear in the application. Note : Install required dev tools viz. Cordova, Adt-bundle, apache-ant, java-jdk, Nodejs etc. Read Cordova CLI documentation for details.
	Author: Anup Tiwari
	Version: 0.1
	Author URI: http://#
*/

function phonegap_top_bar_settings_menu($wp_admin_bar1)
{
    $args = array(
        'id' => 'create-directory',
        'title' => '<p style="font-family: verdana;">Phonegap app generator options</p>',
        'href' => admin_url() . 'admin.php?page=plugin_settings',
        'meta' => array(
            'class' => 'custom-node-class'
        )
    );
    $wp_admin_bar1->add_node($args);
}

add_action('admin_bar_menu', 'phonegap_top_bar_settings_menu', 80);
add_action( 'admin_menu', 'phonegap_settings_menu_page' );

function phonegap_settings_menu_page()
{
    add_menu_page( 'Plugin settings', 'Phonegap app Settings', 'manage_options', 'plugin_settings', 'phonegap_settings_page', plugins_url( 'phonegap-app-generator/images/android-icon-main.png' ), 85 ); 
}

function phonegap_settings_page()
{
    $create_app    = plugins_url() . '/phonegap-app-generator/create_app/index.php';
    $generate_html = plugins_url() . '/phonegap-app-generator/get_html/default.php';
    $get_static    = plugins_url() . '/phonegap-app-generator/get_html/static.php';
    $get_android   = plugins_url() . '/phonegap-app-generator/get_android/platform.php';

    echo("<div class='wrap'><h2 align='center' style='color:#0074a2; font-weight:bold;'>Phonegap Applications Generator</h2><hr><hr><p style='font-size:20px;'>Create application directory<br><span style='font-size:15px; font-weight:bold;'>This action will create the application directory by running cordova commands on the server. <br>Ensure that cordova is successfully running on the command line.</span></p><p><a href='$create_app' class='button button-primary button-large' target='_blank'>Create directory</a></p><br></div>");
    echo("<div class='wrap'><hr><p style='font-size:20px;'>Generate HTML pages<br><span style='font-size:15px; font-weight:bold;'>This action will generate the HMTL files for all the pages created on this wordpress installation.<br> </span></p><p><a href='$generate_html' class='button button-primary button-large' target='_blank'>Generate HTML</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='$get_static' class='button button-primary button-large' target='_blank'>Get static files</a></p><br></div>");
    echo("<div class='wrap'><hr><p style='font-size:20px;'>Get android application<br><span style='font-size:15px; font-weight:bold;'>This action will download the generated Android application which you can then install on a device and use seamlessly.</span></p><p><a href='$get_android' class='button button-primary button-large' target='_blank'>Download Android</a></p><br></div><hr>");
}


/*
Make sure you rename the permanlink of the default page as index.
function generate_html($wp_admin_bar1)
{
    $args = array(
        'id' => 'generate-html',
        'title' => '<p style="font-family: verdana;">Generate HTML pages</p>',
        'href' => plugins_url() . '/phonegap-app-generator/get_html/default.php',
        'meta' => array(
            'class' => 'custom-node-class'
        )
    );
    $wp_admin_bar1->add_node($args);
}

*/

//add_action('admin_bar_menu', 'generate_html', 80);

?>
