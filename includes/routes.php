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
	'about/' => 'route_callback_about'
);

/*
Navigation menu
*/

$menu = array(
	'Home' => '',
	'About' => 'about/',
	'Shipped' => 'shipped/',
	'Clients' => 'clients/',
	'Blog' => 'blog/',
	'Contact' => 'contact/',
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
	$the_dir = $page->content_dir . 'clients/';
	
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
			$pages['link'] = 'blog/' . $file['slug'] . '/';
			
			$page->content['sections'][] = $pages;
			
		endif;
		
	endforeach;
	
}

function route_callback_shipped() {
	
	global $page;
	
	$page->set_page_type('shipped');
	$page->text_file = $page->content_dir . 'shipped.txt';
	$page->get_page_content();
	
	$page->content['sections'] = array(
			array(
			'title' => 'WP-Drudge Content Curation',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Premium Theme',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'WordPress',
			// Direct link to a thumbnail URL
			'image' => 'http://url.com/path/to/image.png',
			// One sentance description
			'description' => 'Short blurb of text',
			// Main info link
			'link' => 'http://wpdrudge.com',
			// Additional links like repos, posts, etc
			'other_links' => array(
				'Updates' => 'http://tinyletter.com/wpdrudge',
				'Demo' => 'http://wpdrudge.com/curation',
			),
		),
		array(
			'title' => 'WP-Soft-Sell Software Sales',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Premium Theme',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'WordPress',
			// Direct link to a thumbnail URL
			'image' => 'http://url.com/path/to/image.png',
			// One sentance description
			'description' => 'Short blurb of text',
			// Main info link
			'link' => 'http://wpsoftsell.com',
			// Additional links like repos, posts, etc
			'other_links' => array(
				'Updates' => 'http://tinyletter.com/wpsoftsell',
			),
		),
		array(
			'title' => 'WP Writer\'s Block',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Theme in progress',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'WordPress',
			// Direct link to a thumbnail URL
			'image' => 'http://url.com/path/to/image.png',
			// One sentance description
			'description' => 'Short blurb of text',
			// Main info link
			'link' => 'http://wpwritersblock.com',
			// Additional links like repos, posts, etc
			'other_links' => array(
				'Updates' => 'http://tinyletter.com/wpwritersblock',
			),
		),
		array(
			'title' => 'Proper Widgets',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Plugin',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'WordPress',
			// Direct link to a thumbnail URL
			'image' => 'http://url.com/path/to/image.png',
			// One sentance description
			'description' => 'Short blurb of text',
			// Main info link
			'link' => 'http://wpwritersblock.com',
			// Additional links like repos, posts, etc
			'other_links' => array(
				'Github' => 'https://github.com/joshcanhelp/proper-widgets',
				'Donate' => '/shipped/wordpress/proper-widgets',
			),
		),
		array(
			'title' => 'Proper Contact Platform',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Plugin in progress',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'WordPress',
			// Direct link to a thumbnail URL
			'image' => 'http://url.com/path/to/image.png',
			// One sentance description
			'description' => 'An easy way to create, process, and store contact forms on a WordPress site.',
			// Main info link
			'link' => 'https://github.com/joshcanhelp/proper-contact-platform',
			// Additional links like repos, posts, etc
			'other_links' => array(
				'Donate' => '/shipped/wordpress/proper-widgets',
			),
		),
		array(
			'title' => 'Simple Markdown-based "CMS"',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Open Source software',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'PHP',
			// One sentance description
			'description' => 'The script that runs this site. A simple, fast, database free way for PHP developers to manage a site.',
			// Main info link
			'link' => 'https://github.com/joshcanhelp/plain-text-site',
		),
		array(
			'title' => 'PHP Form Builder',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Open Source software',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'PHP',
			// One sentance description
			'description' => 'A simple and easy way for PHP developers to output valid, HTML5 and XHTML forms.',
			// Main info link
			'link' => 'https://github.com/joshcanhelp/php-form-builder',
		)
	);
	
	
}