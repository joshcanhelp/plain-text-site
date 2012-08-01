<?php 
/*
Routes that the site will respond to
*/
$routes = array();

// Key is a path, value is a URL
$routes['redirects'] = array(
	'hey/' => 'http://joshcanhelp.com'
);

// Key is a path, value is a callback function
$routes['callbacks'] = array(
	'phpinfo/' => 'phpinfo',
	'shipped/' => 'route_callback_shipped',
	'blog/' => 'route_callback_blog',
	'code/' => 'route_callback_code',
	'about/' => 'route_callback_about'
);


/*
Route callbacks


global $page;

$page->set_page_type('blog');
$page->text_file = $page->content_dir . 'blog.txt';
$page->get_page_content();

*/

function route_callback_about() {

	global $page;
	
	$page->set_page_type('landing');
	$page->text_file = $page->content_dir . 'about.txt';
	$page->get_page_content();
	
	$split = get_option('markdown_split');
	$the_dir = $page->content_dir . 'about/';
	
	$page->sub_pages = array();
	
	$file_content = read_txt_files($the_dir);
	
	foreach ($file_content as $file) :
		
		if (strpos($file['content'], $split) !== false) :
				
			$arr = explode($split, $file['content']);
			$pages = parse_page_metas($arr[0]);
			$pages['link'] = 'about/' . $file['slug'];
			
			$page->content['sections'][] = $pages;
			
		endif;
		
	endforeach;
	
}

function route_callback_shipped() {

	global $page;

	$page->set_page_type('shipped');
	$page->text_file = $page->content_dir . 'shipped.txt';
	$page->get_page_content();
	
	$split = get_option('section_split');
	$the_dir = $page->content_dir . 'shipped/';
	
	$file_content = read_txt_files($the_dir);
	
	foreach ($file_content as $file) :
		
		$content_arr = explode($split, $file['content']);
		$marked_down = array();
		
		foreach ($content_arr as $content) :
			$marked_down[] = Markdown($content);
		endforeach;
			
		$page->content['sections'][] = $marked_down;
		
	endforeach;
	
}

function route_callback_blog() {
	
	global $page;
	
	$page->set_page_type('blog');
	$page->text_file = $page->content_dir . 'blog.txt';
	$page->get_page_content();
	
	$split = get_option('markdown_split');
	$the_dir = $page->content_dir . 'blog/';
	
	$page->sub_pages = array();
	
	$file_content = read_txt_files($the_dir);
	
	foreach ($file_content as $file) :
		
		if (strpos($file['content'], $split) !== false) :
				
			$arr = explode($split, $file['content']);
			$pages = parse_page_metas($arr[0]);
			$pages['link'] = 'blog/' . $file['slug'];
			
			$page->content['sections'][] = $pages;
			
		endif;
		
	endforeach;
	
}

function route_callback_code() {
	
	$github = 'https://github.com/joshcanhelp.atom';
	
}