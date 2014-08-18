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

if (is_user_logged_in() ) {
	# code...
	$admin_url = admin_url() . 'admin.php?page=plugin_settings';
	echo "<p style='font-size:20px;''>HTML Pages generated in the application directory.<br><a href='$admin_url'>Go back to admin panel!</a></p>";

	// include simple_html_dom parser
	include( 'simple_html_dom.php' );

		$app_name = str_replace( 'http://' . $_SERVER['SERVER_NAME'] . '/' , "", site_url()) ;
		$cwd = ABSPATH;
		chdir( $cwd . '/' . $app_name );
		$directory = getcwd();
		$index = get_site_url() . '/';
		$pages = get_pages();
		array_push( $pages, $index );

	foreach ( $pages as $page ) 
	{
		$page_link = get_page_link( $page->ID );
		$page_html = file_get_html( $page_link );
		$dom       = new DOMDocument();
		@$dom->loadHTML( $page_html );

		$css_location   = $directory . '/www/' . 'css/';
		$js_location    = $directory . '/www/' . 'js/';
		$image_location = $directory . '/www/' . 'img/';

		$links   =  $dom->getElementsByTagName( 'link' );
		$scripts =  $dom->getElementsByTagName( 'script' );
		$images  =  $dom->getElementsByTagName( 'img' );

		// Copying Stylesheets
		for( $i=0; $i < $links->length; $i++ ) 
		{
			$rel = $links->item( $i )->getAttribute( 'rel' );
			if ($rel == 'stylesheet') 
			{
				$attr = $links->item( $i )->getAttribute( 'href' );
				$temp = explode( '?', $attr );
				$attr = $temp[0];
				$file_array   = explode( '/', $attr );
				$name_of_file = end( $file_array );
				if ( pathinfo( $attr )['extension'] == 'css' )
				{
					$path = dirname( $attr );
					$new_path   = substr( $path, strlen( 'http://' . $_SERVER['SERVER_NAME'] . '/' . $app_name . '/' ));
					$final_path = ABSPATH . $new_path . '/' . $name_of_file;
					copy( $final_path, $css_location . $name_of_file );
				}
			}
		}

		// Copying Javascripts
		for( $i=0; $i < $scripts->length; $i++ ) 
		{
			$attr = $scripts->item( $i )->getAttribute( 'src' );
			$temp = str_split( $attr, strripos( $attr,"?" ) );
			$attr = $temp[0];
			$file_array   = explode( '/', $attr );
			$name_of_file = end( $file_array );
			if ( pathinfo( $attr )['extension'] == 'js' ) 
			{
				$path       = dirname( $attr );
				$new_path   = substr( $path, strlen( 'http://' . $_SERVER['SERVER_NAME'] . '/' . $app_name . '/' ));
				$final_path = ABSPATH . $new_path . '/' . $name_of_file;
				copy( $final_path, $js_location . $name_of_file );
			}
		}

		// Copying Images
		for( $i=0; $i < $images->length; $i++ ) 
		{
			$attr = $images->item( $i )->getAttribute( 'src' );
			$file_array   = explode( '/', $attr );
			$name_of_file = end( $file_array );
			if ( pathinfo( $attr )['extension'] == 'jpg' || pathinfo( $attr )['extension'] == 'png' ) 
			{
				$path = dirname( $attr );
				$new_path   = substr( $path, strlen( 'http://' . $_SERVER['SERVER_NAME'] . '/' . $app_name . '/' ));
				$final_path = ABSPATH . $new_path . '/' . $name_of_file;
				copy( $final_path, $image_location . $name_of_file );
			}
		}
	}

	function phonegap_generator_modify_pages( $pages, $links, $scripts, $images )
	{
		$directory = getcwd();
		$new_css_file_name = array(); 
		$old_css_file_name = array();
		$new_js_file_name  = array(); 
		$old_js_file_name  = array();
		$new_img_file_name = array(); 
		$old_img_file_name = array();
		$new_page_links    = array(); 
		$old_page_links    = array();
		
		for( $i=0; $i < $links->length; $i++ ) 
		{
			$rel = $links->item( $i )->getAttribute( 'rel' );
			if ( $rel == 'stylesheet' ) 
			{
				$attr = $links->item( $i )->getAttribute( 'href' );
				$temp = str_split( $attr, strripos( $attr, "?" ) );
				$attr = $temp[0];
				array_push( $old_css_file_name, $attr );
				$qwer  = str_split( $attr, strripos( $attr,".css" ) );
				$qwer1 = str_split( $attr, strripos( $qwer[0], "/") );
				array_push( $new_css_file_name, 'css' . $qwer1[1] );
			}
		}

		for ( $i=0; $i < $scripts->length ; $i++ ) 
		{ 
			$attr = $scripts->item( $i )->getAttribute( 'src' );
			$temp = str_split( $attr, stripos( $attr, "?" ) );
			$attr = $temp[0];
			array_push( $old_js_file_name, $attr );
			$qwer1 = explode( '/', $attr );
			$qwer2 = end( $qwer1 );
			array_push( $new_js_file_name, 'js/' . $qwer2 );
		}

		for ( $i=0; $i < $images->length ; $i++ ) 
		{ 
			$attr = $images->item( $i )->getAttribute( 'src' );
			array_push( $old_img_file_name , $attr);
			$file_array   = explode( '/', $attr );
			$name_of_file = end( $file_array );
			array_push( $new_img_file_name, 'img/' . $name_of_file);
		}

		foreach ( $pages as $page ) 
		{
			$temp_page_link = get_page_link( $page->ID );
			array_push( $old_page_links, $temp_page_link );
			$page_link = rtrim( $temp_page_link, "/" );
			$page_name = str_replace( site_url() . '/', "", $page_link );
			array_push( $new_page_links, $page_name . '.html' );
		}

		foreach ( $pages as $page )
		{
			$temp_page_link = get_page_link( $page->ID );
			$html      = file_get_html( $temp_page_link );
			$a_home    = $html->find('a[rel=home]');
			$page_link = rtrim( $temp_page_link, "/" );
			$page_name = str_replace( site_url() . '/', "", $page_link );

			if ($page == get_site_url()) 
			{
				$my_file = $directory . '/www/' . 'index.html';
			}

			$my_file = $directory . '/www/' . $page_name . '.html';
			$handle = fopen( $my_file, 'w' ) or die( 'Cannot open file: ' . $my_file );
			$new_html_of_this_page = $html;

			for ( $i=0; $i < sizeof( $new_css_file_name ); $i++ )
			{
				$new_html_of_this_page = str_replace( $old_css_file_name[$i], $new_css_file_name[$i], $new_html_of_this_page );
			}

			for ($i=0; $i < sizeof( $old_js_file_name ); $i++ ) 
			{ 
				$new_html_of_this_page = str_replace( $old_js_file_name[$i], $new_js_file_name[$i], $new_html_of_this_page );
			}

			for ($i=0; $i < sizeof( $old_page_links ); $i++ ) 
			{ 
				$new_html_of_this_page = str_replace( $old_page_links[$i], $new_page_links[$i], $new_html_of_this_page );
			}

			for ($i=0; $i < sizeof( $old_img_file_name ); $i++ ) 
			{ 
				$new_html_of_this_page = str_replace( $old_img_file_name[$i], $new_img_file_name[$i], $new_html_of_this_page);
			}

			$app_name = str_replace( 'http://' . $_SERVER['SERVER_NAME'] . '/' , "", site_url()) ;
			$new_html_of_this_page = str_replace( $a_home , "<a rel='home' class='navbar-brand' href='index.html'>". ucfirst( $app_name ) ."</a>", $new_html_of_this_page );

			fwrite( $handle, $new_html_of_this_page );
			fclose( $handle );
		}
	}

	phonegap_generator_modify_pages( $pages, $links, $scripts, $images);

} else 
{
	$url = get_site_url() . '/wp-login.php' ;
    redirect($url);
}

// End of file