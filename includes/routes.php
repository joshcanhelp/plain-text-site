<?php 
/*
Routes that the site will respond to
*/
$routes = array();

// Key is a path, value is a URL
$routes['redirects'] = array(
	'josh/' => 'http://joshcanhelp.com'
);

// Key is a path, value is a callback function
$routes['callbacks'] = array(
	'phpinfo/' => 'phpinfo',
	'clients/' => 'route_callback_clients',
	'blog/' => 'route_callback_blog',
	'shipped/' => 'route_callback_shipped',
	'about/' => 'route_callback_about',
	// 'contact/' => 'route_callback_contact'
);

/*
Navigation menu
*/

$menu = array(
	'About' => 'about/',
	'Clients' => 'clients/',
	'Shipped' => 'shipped/',
	'Blog' => 'blog/',
	'Contact' => 'contact/',
);


/*
Route callbacks
*/

function route_callback_home() {

	global $page;

	$page->set_page_type('home');
	$page->text_file = $page->content_dir . 'home.txt';
	$page->get_page_content();
	
	$split = get_option('section_split');
	
	$content_arr = explode($split, $page->content['markdown']);
	
	$page->content['sections'] = array();
	
	foreach ($content_arr as $content) :
		$page->content['sections'][] = Markdown($content);
	endforeach;
	
	$page->content['html'] = array_shift($page->content['sections']);
		
}

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
		
		if (strpos($file['content'], $split) !== FALSE) :
				
			$arr = explode($split, $file['content']);
			$pages = parse_page_metas($arr[0]);
			$pages['link'] = 'about/' . $file['slug'] . '/';
			
			$page->content['sections'][] = $pages;
			
		endif;
		
	endforeach;
	
}

function route_callback_clients() {

	global $page;

	$page->set_page_type('clients');
	$page->text_file = $page->content_dir . 'clients.txt';
	$page->get_page_content();

	$split = get_option('section_split');

	$content_arr = explode($split, $page->content['markdown']);
	$marked_down = array();

	foreach ($content_arr as $content) :
		$marked_down[] = Markdown($content);
	endforeach;

	$page->content['sections'] = $marked_down;


}

function route_callback_blog() {
	
	global $page;
	
	$page->set_page_type('blog');
	$page->text_file = $page->content_dir . 'blog.txt';
	$page->get_page_content();
	
	$split = get_option('markdown_split');
	$the_dir = $page->content_dir . 'blog/';
	
	$file_content = read_txt_files($the_dir);
	
	foreach ($file_content as $file) :
		
		if (strpos($file['content'], $split) !== FALSE) :
				
			$arr = explode($split, $file['content']);
			$pages = parse_page_metas($arr[0]);
			$pages['link'] = 'blog/' . $file['slug'] . '/';
			
			$page->content['sections'][] = $pages;
			
		endif;
		
	endforeach;
	
}

function route_callback_shipped() {
	
	global $page, $query;
	
	$page->set_page_type('shipped');
	$page->text_file = $page->content_dir . 'shipped.txt';
	
	$page->content['markdown'] = file_get_contents($page->text_file);
	$page_content = explode(get_option('section_split'), $page->content['markdown']);
	$page->content['markdown'] = $page_content[0];
	
	$page->get_page_content();
	
	for ($i = 1; $i < count($page_content); $i++) :
		$page->content['sections'][] = parse_page_metas($page_content[$i]);
	endfor;
	
}


/*
Include a user-created routes file, if available
*/

$user_routes_path = dirname(__FILE__) . '/user-routes.php';
if (file_exists($user_routes_path)) 
	require_once($user_routes_path);