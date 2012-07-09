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
	'blog/' => 'route_callback_blog',
	'code/' => 'route_callback_code'
);


/*
Route callbacks


global $page;

$page->set_page_type('type');
$page->set_page_metas(array(
	'title' => 'This is the title',
	'description' => 'This is the description'
));

*/

function route_callback_blog() {
	
	global $page;
	
	$split = get_option('markdown_split');
	$blog_dir = 'blog/';
	
	$page->set_page_type('blog');
	$page->set_page_metas(array(
		'title' => 'This be the blog',
		'description' => 'We blog like motherfucking bats out of hell'
	));
	
	// Open blog post directory
	if (is_dir($page->content_dir . $blog_dir))
		$dir = opendir($page->content_dir . $blog_dir);
	else
		return;
		
	$page->sub_pages = array();
	// Read through all the files
	while(($file = readdir($dir)) !== false) :
		
		$file_pieces = explode('.', $file);
		
		if ($file_pieces[1] === 'txt') :
			
			$file_content = file_get_contents($page->content_dir . $blog_dir .  $file);
			
			if (strpos($file_content, $split) !== false) :
			
				$arr = explode($split, $file_content);
				$pages = parse_page_metas($arr[0]);
			
				$pages['path'] = $blog_dir . $file_pieces[0];
				
				$page->sub_pages[] = $pages;
				
			endif;
			
		endif;
		
	endwhile;
	
	closedir($dir);
	
	$page->content['html'] = display_sub_pages($page->sub_pages);
	
}

function route_callback_code() {
	
	$github = 'https://github.com/joshcanhelp.atom';
	
}