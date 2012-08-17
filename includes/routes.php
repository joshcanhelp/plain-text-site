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
	'contact/' => 'route_callback_contact'
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
	
	global $page, $query;
	
	$page->set_page_type('shipped');
	$page->text_file = $page->content_dir . 'shipped.txt';
	$page->get_page_content();
	
	$page->content['sections'] = array(
			array(
			'title' => 'WP Writer\'s Block',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Theme in progress',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'WordPress',
			// Direct link to a thumbnail URL
			'image' => $query['base'] . 'images/shipped/wp-writers-block-thumb.jpg',
			// One sentance description
			'description' => 'WP Writer\'s Block is an in-progess WordPress template for authors, journalists, and others who make their living assembling words.',
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
			'image' => $query['base'] . 'images/shipped/proper-widgets-thumb.png',
			// One sentance description
			'description' => 'Proper Widgets are well-coded, useable widgets for any WordPress installation.',
			// Main info link
			'link' => 'http://wordpress.org/extend/plugins/proper-widgets/',
			// Additional links like repos, posts, etc
			'other_links' => array(
				'Github' => 'https://github.com/joshcanhelp/proper-widgets',
				'Donate' => '/shipped/wordpress/proper-widgets',
			),
		),
			array(
			'title' => 'WP-Drudge Content Curation',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Premium Theme',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'WordPress',
			// Direct link to a thumbnail URL
			'image' => $query['base'] . 'images/shipped/wp-drudge-thumb.png',
			// One sentance description
			'description' => 'WP-Drudge is a Drudge Report style (no affiliation) WordPress theme that makes it easy to post external articles, your own blog posts, and links to other sites.',
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
			'image' => $query['base'] . 'images/shipped/wp-soft-sell-thumb.png',
			// One sentance description
			'description' => 'The WP-Soft-Sell WordPress theme creates an easy way to distribute your digital goods by building a sales page and providing a documentation template.',
			// Main info link
			'link' => 'http://wpsoftsell.com',
			// Additional links like repos, posts, etc
			'other_links' => array(
				'Updates' => 'http://tinyletter.com/wpsoftsell',
			),
		),
		array(
			'title' => 'Proper Contact Platform',
			// What is it? Git repo, Premium WP theme, WP repo plugin, blog post, client feature
			'type' => 'Plugin in progress',
			// Platform built on... WordPress, Drupal, jQuery, etc
			'platform' => 'WordPress',
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

function route_callback_contact() {
	
	global $page;
	
	require_once('classes/FormBuilder.php');
	
	$page->set_page_type('contact');
	$page->text_file = $page->content_dir . 'contact.txt';
	$page->get_page_content();
	
	/*
	Regular contact form for questions
	*/
	$form_contact = new ThatFormBuilder();
	
	// Required name field
	$form_contact->add_input('Ask a question!', array(
		'type' => 'title'
	));
	
	// Required name field
	$form_contact->add_input('How shall we address you?', array(
		'required' => true,
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['contact-name']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-name--notempty');
	
	// Required email field
	$form_contact->add_input('How can we reach you? Email or US phone number will do just fine here.', array(
		'required' => true,
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['contact-email']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-method--emailphone');
	
	// Comment field
	$form_contact->add_input('And, finally, your question or comment. How can we help?', array(
		'required' => true,
		'type' => 'textarea',
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['question-or-comment']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-comment--notempty');
	
	
	// IP Address
	$form_contact->add_input('Contact IP', array(
		'type' => 'hidden',
		'value' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''
	));
	
	// Referring site
	$form_contact->add_input('Contact Referrer', array(
		'type' => 'hidden',
		'value' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''
	));
	
	// Referring page
	if (isset($_REQUEST['src']) || isset($_REQUEST['ref'])) :
		$form_contact->add_input('Referring page', array(
			'type' => 'hidden',
			'value' => isset($_REQUEST['src']) ? $_REQUEST['src'] : $_REQUEST['ref']
		));
	endif;
	
	$page->content['sections'][] = $form_contact->build_form(false);
	
	
	/*
	Project request
	*/
	$form_project = new ThatFormBuilder();
	
	// Required name field
	$form_project->add_input('Request a project!', array(
		'type' => 'title'
	));
	
	// Required name field
	$form_project->add_input('Who will we be talking to?', array(
	'required' => true,
	'wrap_class' => isset($_SESSION['cfp_contact_errors']['contact-name']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-name--notempty');
	
	// Required email field
	$form_project->add_input('What is an email address or US phone number we can contact you at?', array(
		'required' => true,
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['contact-email']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-method--emailphone');
	
	// Comment field
	$form_project->add_input('So, please, tell us a bit about your project - just a brief overview will do', array(
		'required' => true,
		'type' => 'textarea',
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['question-or-comment']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-comment--notempty');
	
	// Existing URL
	$form_project->add_input('Is there an existing URL we can look at?', array(
		'type' => 'url',
	), 'contact-url');
	
	// Timing
	$form_project->add_input('What is the time frame we\'re looking at', array(
		'type' => 'select',
		'required' => true,
		'options' => array(
			'' => 'Timing...',
			'now' => 'Right away',
			'soon' => 'Soon but not urgent',
			'later' => 'Not soon but eventually',
			'unknown' => 'Not sure'
		)
	), 'contact-timing--notempty');
	
	// IP Address
	$form_project->add_input('Contact IP', array(
		'type' => 'hidden',
		'value' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''
	));
	
	// Referring site
	$form_project->add_input('Contact Referrer', array(
		'type' => 'hidden',
		'value' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''
	));
	
	// Referring page
	if (isset($_REQUEST['src']) || isset($_REQUEST['ref'])) :
		$form_project->add_input('Referring page', array(
			'type' => 'hidden',
			'value' => isset($_REQUEST['src']) ? $_REQUEST['src'] : $_REQUEST['ref']
		));
	endif;
	
	$page->content['sections'][] = $form_project->build_form(false);
	
	
	/*
	Want to work with us
	*/
	$form_team = new ThatFormBuilder();
	
	// Required name field
	$form_team->add_input('Join our team!', array(
		'type' => 'title'
	));
	
	// Required name field
	$form_team->add_input('Who will we be talking to?', array(
	'required' => true,
	'wrap_class' => isset($_SESSION['cfp_contact_errors']['contact-name']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-name--notempty');
	
	// Required email field
	$form_team->add_input('What is an email address or US phone number we can contact you at?', array(
		'required' => true,
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['contact-email']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-method--emailphone');
	
	// Existing URL
	$form_team->add_input('Where can we see some of your work?', array(
		'type' => 'url',
	), 'contact-url');
	
	// Comment field
	$form_team->add_input('So, please, tell us a bit about yourself. Include additional URLs if you\'ve got them', array(
		'required' => true,
		'type' => 'textarea',
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['question-or-comment']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-comment--notempty');
	
	// Postion
	$form_team->add_input('What kind of position are you looking for?', array(
		'type' => 'select',
		'options' => array(
			'' => 'Position...',
			'ops' => 'Admin or support',
			'cms' => 'CMS programming',
			'front' => 'Front-end engineering',
			'design' => 'Design',
			'else' => 'Something else'
		)
	), 'contact-position');
	
	// IP Address
	$form_team->add_input('Contact IP', array(
		'type' => 'hidden',
		'value' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''
	));
	
	// Referring site
	$form_team->add_input('Contact Referrer', array(
		'type' => 'hidden',
		'value' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''
	));
	
	// Referring page
	if (isset($_REQUEST['src']) || isset($_REQUEST['ref'])) :
		$form_team->add_input('Referring page', array(
			'type' => 'hidden',
			'value' => isset($_REQUEST['src']) ? $_REQUEST['src'] : $_REQUEST['ref']
		));
	endif;
	
	$page->content['sections'][] = $form_team->build_form(false);
	
	/*
	Existing client request
	*/
	$form_client = new ThatFormBuilder();
	
	// Required name field
	$form_client->add_input('Submit a change or bug request', array(
		'type' => 'title'
	));
	
	// Required name field
	$form_client->add_input('Hi there! Who are we speaking to?', array(
		'required' => true,
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['contact-name']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-name--notempty');
	
	// Existing URL
	$form_client->add_input('Is there a relevant link you can provide? Either where the problem is appearing or where the change needs to be made', array(
		'type' => 'url',
	), 'contact-url');
	
	// Comment field
	$form_client->add_input('Describe what\'s going on, if you would. The more detailed you can be, the quicker we can figure this out. Include any additional links you think might help.', array(
		'required' => true,
		'type' => 'textarea',
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['question-or-comment']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-comment--notempty');
	
	// Postion
	$form_client->add_input('How urgent are we talking about?', array(
		'type' => 'select',
		'options' => array(
			'' => 'Urgency...',
			'minor' => 'No rush, check it out when you can',
			'medium' => 'Pressing but not on fire',
			'serious' => 'ASAP'
		)
	), 'contact-urgency');
	
	// Required email field
	$form_client->add_input('If we don\'t have an email for you, what is it?', array(
		'type' => 'email',
		'wrap_class' => isset($_SESSION['cfp_contact_errors']['contact-email']) ? array('form_field_wrap', 'error') : array('form_field_wrap')
	), 'contact-method--email');
	
	// IP Address
	$form_client->add_input('Contact IP', array(
		'type' => 'hidden',
		'value' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''
	));
	
	// Referring site
	$form_client->add_input('Contact Referrer', array(
		'type' => 'hidden',
		'value' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''
	));
	
	// Referring page
	if (isset($_REQUEST['src']) || isset($_REQUEST['ref'])) :
		$form_client->add_input('Referring page', array(
			'type' => 'hidden',
			'value' => isset($_REQUEST['src']) ? $_REQUEST['src'] : $_REQUEST['ref']
		));
	endif;
	
	$page->content['sections'][] = $form_client->build_form(false);
	
}