<?php 
$time_start = microtime(true);

ini_set('display_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ALL ^ E_NOTICE);

// Database and site options, important constants
require_once 'inc/config.php';

require_once 'classes/PageBuilder.php';
$page = new PageBuilder;

require_once 'inc/functions.php';


// Twig - lightweight templating
require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
	//'cache'		=>	'templates/cache'
));


// Store base of current site
$page->base = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

// Store the page path being requested
$page->path = str_replace($page->base, '', $_SERVER['REQUEST_URI']);

// get all pieces of the path
$pieces = explode('/', urldecode($page->path));

// The main routing happens from the first section of the path
$page->route = $pieces[0];

// The query is always the 2nd piece of the URL
$page->query['original'] = urldecode($pieces[1]);
$page->query['integer'] = intify($page->query['original']);
$page->query['length'] = strlen($page->query['integer']);


// Main page routing
switch ($page->route) :
	
	// Getting a regular content page
	case 'p' :
		if (! $page->get_content_page()) $page->make_404();
		break;
	
	// Getting an area code
	case 'area-code' :
		if ($page->query['length'] == 3) $page->get_area_code();
		else $page->errors[] = 'Area code entered is the wrong number of digits (' . $page->query['length'] . ' instead of 3)';
		$page->meta['title'] = 'Area code information for ' . $page->query['formatted'];
		break;
	
	// Getting a prefix
	case 'prefix' :
		if ($page->query['length'] == 6) $page->get_prefix();
		else $page->errors[] = 'Prefix entered is the wrong number of digits (' . $page->query['length'] . ' instead of 6)';
		$page->meta['title'] = 'Prefix information for ' . $page->query['formatted'];
		break;
	
	// Getting a phone number
	case 'phone' :
		if ($page->query['length'] == 10) $page->get_phone();
		else $page->errors[] = 'Phone number entered is the wrong number of digits (' . $page->query['length'] . ' instead of 10)';
		$page->meta['title'] = 'Phone number information for ' . $page->query['formatted'];
		break;
		
	// Searching 
	case 'search' :
		break;
		
	default :
		$page->make_404();
		
endswitch; 

// Render the page template
echo $twig->render($page->template, array(
	'page'				=> $page,
	'the_nav'			=> get_nav_file_names()
));

$page->timer = (microtime(true) - $time_start);

echo '<pre>';print_r($page);echo '</pre>';

