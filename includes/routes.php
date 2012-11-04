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
	
	global $page, $query;
	
	$page->content['sections'][0] = '';
	
	if (isset($_POST['submit']) && $_POST['submit'] === 'Submit') : 
		if (process_contact()) header('Location: http://' . $_SERVER['HTTP_HOST'] . $query['base'] . 'thank-you');
		else $page->content['sections'][0] .= proper_display_errors	($_SESSION['contact_errors']);
	endif;
	
	require_once('classes/FormBuilder.php');
	
	$page->set_page_type('contact');
	$page->text_file = $page->content_dir . 'contact.txt';
	$page->get_page_content();
	
	/*
	Regular contact form for questions
	*/
	$form_contact = new ThatFormBuilder();
	
	// Required name field
	$form_contact->add_input('How shall we address you?', array(
		'required' => true
	), 'contact-name');
	
	// Required email field
	$form_contact->add_input('How can we reach you? Email or US phone number will do just fine here.', array(
		'required' => true
	), 'contact-method');
	
	/*
	General contact fields
	*/
	
	// Comment field
	
	$form_contact->add_input('And, finally, your question or comment. How can we help?', array(
		'wrap_class' => array('form_field_wrap', 'contact-general'),
		'type' => 'textarea',
	), 'contact-general-comment');
	
	
	/*
	Project request fields
	*/
	
	// Comment field
	$form_contact->add_input('So, please, tell us a bit about your project - just a brief overview will do', array(
		'wrap_class' => array('form_field_wrap', 'contact-project'),
		'type' => 'textarea'
	), 'contact-project-comment');
	
	// Existing URL
	$form_contact->add_input('Is there an existing URL we can look at?', array(
		'wrap_class' => array('form_field_wrap', 'contact-project'),
		'type' => 'url',
	), 'contact-project-url');
	
	// Timing
	$form_contact->add_input('What is the time frame we\'re looking at', array(
		'wrap_class' => array('form_field_wrap', 'contact-project'),
		'type' => 'select',
		'options' => array(
			'' => 'Timing...',
			'now' => 'Right away',
			'soon' => 'Soon but not urgent',
			'later' => 'Not soon but eventually',
			'unknown' => 'Not sure'
		)
	), 'contact-project-timing');
	
	
	/*
	Want to work with us fields
	*/
	
	// Existing URL
	$form_contact->add_input('Where can we see some of your work?', array(
		'wrap_class' => array('form_field_wrap', 'contact-work'),
		'type' => 'url',
	), 'contact-work-url');
	
	// Comment field
	$form_contact->add_input('So, please, tell us a bit about yourself. Include additional URLs if you\'ve got them', array(
		'wrap_class' => array('form_field_wrap', 'contact-work'),
		'type' => 'textarea'
	), 'contact-work-comment');
	
	// Postion
	$form_contact->add_input('What kind of position are you looking for?', array(
		'wrap_class' => array('form_field_wrap', 'contact-work'),
		'type' => 'select',
		'options' => array(
			'' => 'Position...',
			'ops' => 'Admin or support',
			'cms' => 'CMS programming',
			'front' => 'Front-end engineering',
			'design' => 'Design',
			'else' => 'Something else'
		)
	), 'contact-work-position');
	
	
	/*
	Bug report fields
	*/
	
	// Existing URL
	$form_contact->add_input('Is there a relevant link you can provide? Either where the problem is appearing or where the change needs to be made', array(
		'wrap_class' => array('form_field_wrap', 'contact-bug'),
		'type' => 'url',
	), 'contact-bug-url');
	
	// Comment field
	$form_contact->add_input('Describe what\'s going on, if you would. The more detailed you can be, the quicker we can figure this out. Include any additional links you think might help.', array(
		'wrap_class' => array('form_field_wrap', 'contact-bug'),
		'type' => 'textarea',
	), 'contact-bug-comment');
	
	// Urgency
	$form_contact->add_input('How urgent are we talking about?', array(
		'wrap_class' => array('form_field_wrap', 'contact-bug'),
		'type' => 'select',
		'options' => array(
			'' => 'Urgency...',
			'minor' => 'No rush, check it out when you can',
			'medium' => 'Pressing but not on fire',
			'serious' => 'ASAP'
		)
	), 'contact-bug-urgency');
	
	
	/*
	Additional contact form fields
	*/
	
	// Contact group
	$form_contact->add_input('Contact Group', array(
		'type' => 'hidden',
		'value' => ''
	));
	
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
		$form_contact->add_input('Referral code', array(
			'type' => 'hidden',
			'value' => isset($_REQUEST['src']) ? $_REQUEST['src'] : $_REQUEST['ref']
		));
	endif;
	
	$page->content['sections'][0] .= $form_contact->build_form(false);
	
}

function process_contact() {
	
	// Session variable for form errors
	$_SESSION['contact_errors'] = array();
	
	// If honeypot is not empty, escape
	if (! empty($_POST['honeypot'])) 
		$_SESSION['contact_errors']['honeypot'] = 'No spam please!';
	
	$body = "
*** Contact form submission on PROPER\n\n";
	
	// Sanitize and validate name
	$contact_name = filter_var($_POST['contact-name'], FILTER_SANITIZE_STRING);
	if (empty($contact_name)) 
		$_SESSION['contact_errors']['contact-name'] = 'Enter your name';
	else 
		$body .= "
Name: $contact_name\n";
	
	// Sanitize and validate email
	$contact_method = filter_var($_POST['contact-method'], FILTER_SANITIZE_STRING);
	if (empty($contact_method)) 
		$_SESSION['contact_errors']['contact-method'] = 'Enter an email or phone number';
	elseif (strpos($contact_method, '@') !== false && ! filter_var($contact_method, FILTER_VALIDATE_EMAIL) ) 
		$_SESSION['contact_errors']['contact-method'] = 'Enter a valid email';
	elseif (preg_replace('/\D/', '', $contact_method) < 9) 
		$_SESSION['contact_errors']['contact-method'] = 'Enter a valid phone number';
	else
		$body .= "
Phone/Email: $contact_method\r
Search: https://www.google.com/#q=$contact_method\n";
		
	// Sanitize contact reason
	$contact_group = $_POST['contact-group'];
	if (empty($contact_group)) 
		$_SESSION['contact_errors']['contact-group'] = 'Please choose a contact type';
	else
		$body .= "
Contact group: $contact_group\n";
	
	switch ($contact_group) :
	
		case 'contact-general':
			
			/*
			General contact
			*/
			$body .= "
Type: General contact\n";
			
			$contact_comment = filter_var($_POST['contact-general-comment'], FILTER_SANITIZE_STRING);
			if (empty($contact_name)) 
				$_SESSION['contact_errors']['contact-general-comment'] = 'Enter your question or comment';
			else 
				$body .= "
Comment: $contact_comment\n";
			
			break;
		
		case 'contact-project':
			
			/*
			Project request
			*/
			
			$body .= "
Type: New project\n";
			
			$contact_comment = filter_var($_POST['contact-project-comment'], FILTER_SANITIZE_STRING);
			if (empty($contact_name)) 
				$_SESSION['contact_errors']['contact-project-comment'] = 'Enter a description of your project';
			else 
				$body .= "
Project description: $contact_comment\n";
			
			$contact_url = filter_var($_POST['contact-project-url'], FILTER_SANITIZE_URL);
			if (!empty($contact_url)) 
				$body .= "
Project URL: $contact_url\n";

			$contact_level = filter_var($_POST['contact-project-timing'], FILTER_SANITIZE_STRING);
			if (empty($contact_level)) 
				$_SESSION['contact_errors']['contact-project-timing'] = 'Select a timeframe for this project';
			else 
				$body .= "
Project timing: $contact_level\n";
			
			break;
		
		case 'contact-work':
		
			/*
			Work request
			*/
			
			$body .= "
Type: Request for work\n";
			
			$contact_comment = filter_var($_POST['contact-work-comment'], FILTER_SANITIZE_STRING);
			if (empty($contact_name)) 
				$_SESSION['contact_errors']['contact-work-comment'] = 'Tell us a bit about yourself';
			else 
				$body .= "
Candidate statement: $contact_comment\n";
			
			$contact_url = filter_var($_POST['contact-work-url'], FILTER_SANITIZE_URL);
			if (!empty($contact_url)) 
				$body .= "
Portfolio URL: $contact_url\n";

			$contact_level = filter_var($_POST['contact-work-position'], FILTER_SANITIZE_STRING);
			if (empty($contact_level)) 
				$_SESSION['contact_errors']['contact-work-position'] = 'Select the type of work you do';
			else 
				$body .= "
Work position: $contact_level\n";
			
			break;
		
		case 'contact-bug':
		
			/*
			Issue submit
			*/
			
			$body .= "
Type: Bug or issue\n";
			
			$contact_comment = filter_var($_POST['contact-bug-comment'], FILTER_SANITIZE_STRING);
			if (empty($contact_name)) 
				$_SESSION['contact_errors']['contact-bug-comment'] = 'Tell us about the issue';
			else 
				$body .= "
Bug description: $contact_comment\n";
			
			$contact_url = filter_var($_POST['contact-bug-url'], FILTER_SANITIZE_URL);
			if (!empty($contact_url)) 
				$body .= "
Bug/issue URL: $contact_url\n";

			$contact_level = filter_var($_POST['contact-bug-urgency'], FILTER_SANITIZE_STRING);
			if (empty($contact_level)) 
				$_SESSION['contact_errors']['contact-bug-urgency'] = 'Select the urgnecy of this issue';
			else 
				$body .= "
Urgency: $contact_level\n";
			
			break;
	
	endswitch;
	
	// Sanitize and validate IP
	$contact_ip = filter_var($_POST['contact-ip'], FILTER_VALIDATE_IP);
	if (!empty($contact_ip)) 
		$body .= "
IP address: $contact_ip \r
IP search: http://whois.domaintools.com/$contact_ip \r
IP search: http://whatismyipaddress.com/ip/$contact_ip)\n";
	
	// Sanitize and prepare referrer
	$contact_referrer = filter_var($_POST['contact-referrer'], FILTER_SANITIZE_STRING);
	if (!empty($contact_referrer)) 
		$body .= "
Came from: $contact_referrer\n";

	// Sanitize and prepare refferal code
	if (isset($_POST['referral-code'])) :
		$contact_ref_code = filter_var($_POST['referral-code'], FILTER_SANITIZE_STRING);
		if (!empty($contact_ref_code)) 
			$body .= "
	Refferal code: $contact_ref_code\n";
	endif;
	
	if (empty($_SESSION['contact_errors'])) : 
		mail('hi@theproperweb.com', 'Contact on PROPER site', $body);
		return true;
	else : 
		return false;
	endif;
	
}