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
$cwd = ABSPATH;
chdir($cwd.'/'.$app_name);
$directory = getcwd();

$index = get_site_url().'/';
$pages = get_pages();
array_push($pages, $index);


foreach ($pages as $page) {
	$page_link = get_page_link($page->ID);
	$page_html = file_get_html($page_link);
	$dom = new DOMDocument();
	@$dom->loadHTML($page_html);
	$css_location = $directory.'/www/'.'css/';
	$js_location = $directory.'/www/'.'js/';

	$links = $dom->getElementsByTagName('link');
	$scripts = $dom->getElementsByTagName('script');

	// Links getting copied
	for($i=0; $i < $links->length; $i++) {
		$attr = $links->item($i)->getAttribute('href');
		$temp = explode('?', $attr);
		$attr = $temp[0];
		if (pathinfo($attr)['extension'] == 'css' ) {
			$path = dirname($attr);
			$new_path = substr($path, strlen('http://'.$_SERVER['SERVER_NAME'].'/'.$app_name.'/'));
			$final_path = ABSPATH.$new_path;
			recurse_copy($final_path,$css_location);
		}
	}

	// Scripts getting copied
	for($i=0; $i < $scripts->length; $i++) {
		$attr = $scripts->item($i)->getAttribute('src');
		$temp = str_split($attr, strripos($attr,"?"));
		$attr = $temp[0];
		if (pathinfo($attr)['extension'] == 'js' ) {
			$path = dirname($attr);
			$new_path = substr($path, strlen('http://'.$_SERVER['SERVER_NAME'].'/'.$app_name.'/'));
			$final_path = ABSPATH.$new_path;
			recurse_copy($final_path,$js_location);
		}
	}
}



modify_pages($pages,$links, $scripts);

function modify_pages($pages, $links, $scripts){
	$directory = getcwd();
	$New_css_file_name =  array();
	$New_js_file_name = array();
	$Old_css_file_name = array();
	$Old_js_file_name = array();
	$Old_page_links = array();
	$New_page_links= array();

	for($i=0; $i < $links->length; $i++) {
		$attr = $links->item($i)->getAttribute('href');
		$temp = str_split($attr, strripos($attr,"?"));
		$attr = $temp[0];
		array_push($Old_css_file_name, $attr);
		$qwer = str_split($attr, strripos($attr,".css"));
		$qwer1 = str_split($attr, strripos($qwer[0], "/"));
		array_push($New_css_file_name, 'css'.$qwer1[1]);
	}

	for ($i=0; $i < $scripts->length ; $i++) { 
		$attr = $scripts->item($i)->getAttribute('src');
		$temp = str_split($attr, stripos($attr, "?"));
		$attr = $temp[0];
		array_push($Old_js_file_name, $attr);
		$qwer1 = explode('/', $attr);
		$qwer2 = end($qwer1);
		array_push($New_js_file_name, 'js/'.$qwer2);
	}

	foreach ($pages as $page) {
		# code...
		$temp_page_link = get_page_link($page->ID);
		array_push($Old_page_links, $temp_page_link);
		$page_link = rtrim($temp_page_link, "/");
		$page_name = str_replace(site_url().'/', "", $page_link);
		array_push($New_page_links, $page_name.'.html');
	}

	foreach ($pages as $page){
		$temp_page_link = get_page_link( $page->ID );
		$html = file_get_html($temp_page_link);
		$page_link = rtrim($temp_page_link, "/");
		$page_name = str_replace(site_url().'/', "", $page_link);
		if ($page == get_site_url()) {
			$my_file = $directory.'/www/'.'index.html';
		}
		$my_file = $directory.'/www/'.$page_name.'.html';
		$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
		$new_html_of_this_page = $html;
		for ($i=0; $i < sizeof($New_css_file_name); $i++){
			$new_html_of_this_page = str_replace($Old_css_file_name[$i], $New_css_file_name[$i], $new_html_of_this_page);
			$new_html_of_this_page = str_replace($Old_js_file_name[$i], $New_js_file_name[$i], $new_html_of_this_page);
			$new_html_of_this_page = str_replace($Old_page_links[$i], $New_page_links[$i], $new_html_of_this_page);
		}
		fwrite($handle, $new_html_of_this_page);
		fclose($handle);
	}
}