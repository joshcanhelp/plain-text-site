<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

/*
Essential functions, database and site options, important constants
*/
require_once 'includes/config.php';
require_once 'includes/routes.php';

require_once 'includes/functions.php';
require_once 'includes/display-functions.php';

/*
Essential classes
*/
require_once 'includes/classes/Markdown.php';
require_once 'includes/classes/Page.php';


/*
Twig - lightweight templating
*/
require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array());


/*
URL parsing
*/
global $query;
$query = get_current_query();


/*
Sets the right URL format
*/
correct_url();


/*
Object for page-specific information
*/
$page = new Page();
$page->get_page();

/*
Set options, load page template
*/

echo $twig->render($page->template, array(
	'query' => $query,
	'page' => $page,
	'nav' => display_nav_menu($menu)
));

echo '<pre>';print_r($query);echo '</pre>';
echo '<pre>';print_r($page);echo '</pre>';
