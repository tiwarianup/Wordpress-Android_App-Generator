<?php
/**
 * @package Phonegap Application 
 * @version 1.0
 */
/*
Plugin Name: Phonegap application generator
	Plugin URI: http://#
	Description: Generate Phonegap Applications. Please ensure to enable disable-comments plugin if you don't want the comments to appear in the application.
	Author: Anup Tiwari
	Version: 0.1
	Author URI: http://#
*/

function create_app($wp_admin_bar1)
{
    $args = array(
        'id' => 'create-directory',
        'title' => 'Create app directory',
        'href' => plugins_url() . '/phonegap-app-generator/create_app/index.php',
        'meta' => array(
            'class' => 'custom-node-class'
        )
    );
    $wp_admin_bar1->add_node($args);
}

function generate_html($wp_admin_bar1)
{
    $args = array(
        'id' => 'generate-html',
        'title' => 'Generate HTML pages',
        'href' => plugins_url() . '/phonegap-app-generator/get_html/default.php',
        'meta' => array(
            'class' => 'custom-node-class'
        )
    );
    $wp_admin_bar1->add_node($args);
}

function get_android($wp_admin_bar1)
{
    $args = array(
        'id' => 'get-android',
        'title' => 'Get Android application',
        'href' => plugins_url() . '/phonegap-app-generator/get_android/index.php',
        'meta' => array(
            'class' => 'custom-node-class'
        )
    );
    $wp_admin_bar1->add_node($args);
}

add_action('admin_bar_menu', 'create_app', 80);
add_action('admin_bar_menu', 'generate_html', 80);
add_action('admin_bar_menu', 'get_android', 80);

?>
