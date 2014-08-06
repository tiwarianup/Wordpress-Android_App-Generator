<?php
// Place this file in plugins directory of your wordpress installation

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


// This just echoes the chosen line, we'll position it later
function stairway($input) {
	echo '<hr><a href="create_app/" target="_blank" style="color:#0074a2; font-size:16px;text-decoration:none;font-family:Open Sans,sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Create application directory for this website</a>'.'<br><hr>';
	echo '<a href="get_html/" target="_blank" style="color:#0074a2; font-size:16px; text-decoration:none;font-family:Open Sans,sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Generate HTML pages for the website</a>'.'<br><hr>';
	echo '<a href="#" target="_blank" style="color:#0074a2; font-size:16px; text-decoration:none;font-family:Open Sans,sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Get android application!</a>'.'<br><hr>';

}

// Now we set that function up to execute when the admin_notices action is called
add_filter( 'admin_head', 'stairway' );
// add_filter( 'the_content', 'page_get_links' );

?>
