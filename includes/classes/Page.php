<?php

/*
FormBuilder!
*/

class Page {
	
	// Page meta title
	// Page type
	// Page template for Twig
	// Markdown content file
	public $title, $description, $type, $template, $text_file, $content_dir; 
	
	public $metas = array();
	
	public $content = array();
	
	function __construct() {
		
		$this->content_dir = get_option('content_dir');
		$this->title = get_option('site_name');
		$this->description = get_option('site_tagline');
		$this->set_page_type('content');
			
  }
	
	/*
	Setter and getter functions
	*/
	
	// Sets up page type and template
	function set_page_type($type) {
		$this->type = $type;
		$this->set_page_template($type . '.html');
	}
	
	// Sets the page template for display
	function set_page_template($tpl) {
		$this->template = $tpl;
	}
	
	// When passed an array, it sets the page title and other metas
	function set_page_metas($metas) {
		
		if (! is_array($metas)) return;
		
		foreach ($metas as $key => $val) :
			
			if ($key == 'meta_title') $this->title = $val;
			elseif ($key == 'description') $this->description = $val;
			else $this->metas[$key] = $val;
			
		endforeach;
		
	}
	
	/*
	Path parsing and content loading
	*/
	
	// Getting page type, template, and Markdown file to use
	function get_page() {
		
		global $query, $routes;
		
		// On the home page
		if (empty($query['path'])) :
			
			// Found in /includes/routes.php
			route_callback_home();
	
		// Check if this is a redirect
		elseif (array_key_exists($query['path'], $routes['redirects'])) :
		
			header('Location: ' . $routes['redirects'][$query['path']]);
	
		// Check if this is a callback
		elseif (array_key_exists($query['path'], $routes['callbacks'])) :
			
			$routes['callbacks'][$query['path']]();
			
		else :
			
			// Creates the path to the content file relative to the content dir
			$text_file = implode('/', $query['pieces']) . '.txt';
			
			// Creates a possible template file to look for
			$tpl_file = get_option('template_dir') . $query['pieces'][0] . '.html';
			
			$this->text_file = $this->content_dir . $text_file;
			
			if (! is_readable($this->text_file)) :
				// Nothing found? 404 
				$this->set_page_type('404');
				$this->text_file = $this->content_dir . '404.txt';
			endif;
			
			// For sub-sections, look for a valid template file
			if (is_readable($tpl_file))
				$this->set_page_type($query['pieces'][0]);
			
			$this->get_page_content();
			
		endif;
		
		if (!isset($this->template)) $this->set_page_type('blank');
		
	}
	
	// Grabs the page content from the Markdown file
	function get_page_content() {
		
		if (empty($this->content['markdown']))
			$this->content['markdown'] = file_get_contents($this->text_file);
		
		// Split on content/meta split text
		$split = get_option('markdown_split');
		
		// Maybe no metas present?
		if (strpos($this->content['markdown'], $split) !== false) :
		
			$arr = explode($split, $this->content['markdown']);
			$this->content['markdown'] = $arr[1];
			$this->content['html'] = Markdown($arr[1]);
			$this->set_page_metas(parse_page_metas($arr[0]));
			
		else :
		
			$this->content['html'] = Markdown($this->content['markdown']);		
			
		endif;
		
	}
	
}