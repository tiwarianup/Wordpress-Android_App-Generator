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

function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false!==($file = readdir($dir))){ 
        if(($file!='.')&&($file!='..')){ 
            if(is_dir($src.'/'.$file)){ 
                recurse_copy($src.'/'.$file,$dst.'/'.$file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 

include('simple_html_dom.php');

$app_name = str_replace( 'http://'.$_SERVER['SERVER_NAME'].'/' , "", site_url());
// echo $app_name.'<br>';
// echo get_theme_root().'<br>';
$cwd = ABSPATH;
chdir($cwd.'/'.$app_name);
$directory = getcwd();
$page_link = get_page_link(2);
echo $page_link.'<br>';

$farzi_html = file_get_html($page_link);
// echo $farzi_html.'<br>';
$dom = new DOMDocument();
@$dom->loadHTML($farzi_html);

// $links = $dom->getElementsByTagName('link'); // Selection of all link tags as an array
// echo $links.'<br>';

$css_location = $directory.'/www/'.'css/';
echo $css_location.'<br>';
$js_location = $directory.'/www/'.'js/';
echo $js_location.'<br>';
// $template = bloginfo('template_url');
// echo $template.'<br>';
$includes = 'http://'.$_SERVER['SERVER_NAME'].'/'.$app_name.'/wp-includes/';
echo $includes.'<br>';

$pages = get_pages(); 
foreach ( $pages as $page ) {
	$temp_page_link = get_page_link( $page->ID );
	echo $temp_page_link.'<br>';
	$html = file_get_html($temp_page_link);
	// echo $html.'<br>';
	$page_link = rtrim($temp_page_link, "/");
	echo $page_link.'<br>';
	$page_name = str_replace(site_url().'/', "", $page_link);
	echo $page_name.'<br>';
	$my_file = $directory.'/www/'.$page_name.'.html';
	$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
	$clean_html_initialize = str_replace(get_template_directory_uri().'/', "", $html );
	// echo $clean_html_initialize.'<br>';
	$clean_html_process = str_replace($includes, "", $clean_html_initialize );
	// echo $clean_html_process.'<br>';
	$final_clean_html = str_replace(site_url().'/', "", $clean_html_process );
	// echo $final_clean_html.'<br>';
	fwrite($handle, $final_clean_html);
	fclose($handle);

	$links = $dom->getElementsByTagName('link'); // Selection of all link tags as an array
	// echo $links.'<br>';
	// var_dump($links).'<br>';
	for ($i=0; $i < $links->length; $i++) {
		$attr = $links->item($i)->getAttribute('href');
		$temp = str_split($attr, strripos($attr,"?"));
		$attr = $temp[0];
		if (pathinfo($attr)['extension'] == 'css' ) {
			$path = dirname($attr);
			echo $path.'<br>';
			$new_path = substr($path, strlen('http://'.$_SERVER['SERVER_NAME'].'/'));
			$final_path = ABSPATH.'/'.$app_name.'/'.$new_path.'/';
			recurse_copy($final_path,$css_location);
		}
	}

	$scripts = $dom->getElementsByTagName('script'); // Selection of all script tags as an array
	// echo $scripts.'<br>';
	//var_dump($scripts).'<br>';
	for ($i=0; $i < $scripts->length; $i++) {
		$attr = $scripts->item($i)->getAttribute('src');
		$temp = str_split($attr, strripos($attr,"?"));
		$attr = $temp[0];
		if (pathinfo($attr)['extension'] == 'js' ) {
			$path = dirname($attr).'<br>';
			$new_path = substr($path, strlen('http://'.$_SERVER['SERVER_NAME'].'/'));
			$final_path = ABSPATH.'/'.$app_name.'/'.$new_path.'/';
			recurse_copy($final_path,$js_location);
		}
	}	
}

/*
$paged = get_pages();
foreach ($paged as $page) {
	# code...
	$page_link = get_page_link($page->ID);
	echo $page_link.'<br>';
	$html = file_get_html($page_link); // getting HTML from the link
    echo $html.'<br>';
	@$dom->loadHTML($page_link); // Loading HTML element as Document Object Model

	$links = $dom->getElementsByTagName('link'); // Selection of all link tags as an array
	echo $links.'<br>';
	var_dump($links).'<br>';

	$scripts = $dom->getElementsByTagName('script'); // Selection of all script tags as an array
	echo $scripts.'<br>';
	var_dump($scripts).'<br>';


	// Extracting all the link tags and copying the css from source to destination folder
	for ($i=0; $i < $links->length; $i++) {
		$attr = $links->item($i)->getAttribute('href');
		$temp = str_split($attr, strripos($attr,"?"));
		$attr = $temp[0];
		if (pathinfo($attr)['extension'] == 'css' ) {
			$path = dirname($attr);
			echo $path.'<br>';
			$new_path = substr($path, strlen('http://'.$_SERVER['SERVER_NAME'].'/'));
			$final_path = ABSPATH.'/'.$app_name.'/'.$new_path.'/';
			recurse_copy($final_path,$css_location);
		}
	}

	// Extracting all the script tags and copying the js from source to destination folder
	for ($i=0; $i < $scripts->length; $i++) {
		$attr = $scripts->item($i)->getAttribute('src');
		$temp = str_split($attr, strripos($attr,"?"));
		$attr = $temp[0];
		if (pathinfo($attr)['extension'] == 'js' ) {
			$path = dirname($attr).'<br>';
			$new_path = substr($path, strlen('http://'.$_SERVER['SERVER_NAME'].'/'));
			$final_path = ABSPATH.'/'.$app_name.'/'.$new_path.'/';
			recurse_copy($final_path,$js_location);
		}
	}
}

*/

	$string = '<html><head><title>Success! HTML pages created</title></head><body><div><p>Congratulations! Go back and generate your app now!<br>Now generate HTML pages for your website.</p><br><a href='.get_admin_url().">Back to admin panel</a></div></body></html>";

	echo $string;
?>
