<?php
/*
Grab a site option
*/

function get_option($name) {
	global $options;
	return $options[$name];
}


/*
Add the slash at the end of the URL
*/

function correct_url() {
	
	global $query;
	
	// If we access the index.php file directly
	// There is only one in the file structure
	if ($query['path'] === 'index.php') :
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: /' . $query['base']);
	// Redirecting to add a trailing slash
	elseif (!empty($query['path']) && $query['path'][strlen($query['path']) - 1] !== '/') :
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $query['base'] . $query['path'] . '/');
	endif;
	
}


/*
Parse the current URL and store important pieces
*/

function get_current_query() {
	
	$url = array();
	
	// Store the full query
	$url['full'] = $_SERVER['REQUEST_URI'];
	
	// Store base of current site
	$url['base'] = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
	
	// Store the page path being requested
	if ($url['base'] != '/')
		$url['path'] = str_replace($url['base'], '', $_SERVER['REQUEST_URI']);
	else
		$url['path'] = substr($_SERVER['REQUEST_URI'], 1);

	$url['parsed'] = parse_url($url['path']);
	
	// Getting all pieces of the path
	$pieces = explode('/', urldecode($url['parsed']['path']));

	for ($i = 0; $i <= count($pieces); $i++) :
		if (!empty($pieces[$i])) {
			$url['pieces'][$i] = $pieces[$i];
			isset( $url['page_id'] ) ? $url['page_id'] .= '-' . $pieces[$i] : $url['page_id'] = $pieces[$i];
		}
	endfor;	
	
	return $url;
	
}


/*
Parse the text file herader for meta info
*/

function parse_page_metas($raw) {
	
	$all_metas = array();
		
	// Make sure the newlines are true newlines
	// Then split apart on those characters
	$raw = str_replace("\r", "\n", $raw);
	$arr = explode("\n", $raw);
	
	foreach ($arr as $val) :
		
		// Format is key : val so we explode and check for both
		$meta = explode(': ', $val);
		if(isset($meta[0]) && isset($meta[1])) $all_metas[trim($meta[0])] = trim($meta[1]);
		
	endforeach;
	
	return $all_metas;
	
}


/*
Create a slug string from any other string
*/

function slugify($string) {
	$string = str_replace(' ', '-', strtolower($string));
	$string = str_replace('_', '-', $string);
	$string = preg_replace("/[^A-Za-z0-9 -]/", '', $string);
	
	return empty($string) ? FALSE : $string;
}


/*
Read through text files in a directory
*/

function read_txt_files($dir) {
	
	// Open blog post directory
	if (is_dir($dir))
		$dir_res = opendir($dir);
	else
		return;
	
	$result = array();
	
	// Read through all the files
	while(($file = readdir($dir_res)) !== FALSE) :
		
		$file_pieces = explode('.', $file);
		
		// Make sure the text file is a text file
		// Also exclude files starting with "_" to allow for making content offline
		if ($file_pieces[1] === 'txt' && $file_pieces[0][0] != '_') :
			
			$result[] = array(
				'slug' => $file_pieces[0],
				'content' => file_get_contents($dir .  $file)
			);
			
		endif;
		
	endwhile;
	
	closedir($dir_res);
	
	return $result;
	
}

/*
Output an error box
*/
if (! function_exists('proper_display_errors')) {
function proper_display_errors($errs) {
	$output = '
	<div class="proper_error_box">
		<h6>Please correct the following errors:</h6>
		<ul>';
	
	foreach ($errs as $err) :
		$output .= "
		<li>$err</li>";
	endforeach;
	
	$output .= '
		</ul>
	</div>';
	
	return $output;
}
}

/*
Look for user function files
*/

$user_file_path = dirname(__FILE__) . '/user-functions.php';
if (file_exists($user_file_path)) 
	require_once($user_file_path);