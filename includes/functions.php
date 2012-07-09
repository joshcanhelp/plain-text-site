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
		if (!empty($pieces[$i])) $url['pieces'][$i] = $pieces[$i];
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
		$meta = explode(':', $val);
		if(isset($meta[0]) && isset($meta[1])) $all_metas[trim($meta[0])] = trim($meta[1]);
		
	endforeach;
	
	return $all_metas;
	
}

