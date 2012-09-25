<?php

/*
Site options configuration
*/
$options = array(
	
	// Use PHP caching to create static pages
	// Set to 0 for no caching
	// Set to -1 for indefinite caching
	// Set to a positive integer to cache for x number of days
	// If caching was set previously and then turned off, cache files need to be deleted
	'php_cache' => 0,
	// Sets the cache directory from the install root
	'php_cache_dir' => 'templates/cache/',
	
	// Site name for default title, etc
	'site_name' => 'Brown Cutlass',
	
	// Tagline for default meta desc, etc
	'site_tagline' => 'We build some shit for you',
	
	// Markdown content directory
	//'content_dir' => 'https://dl.dropbox.com/u/64275/content/',
	'content_dir' => 'content/',
	
	// Twig template directory
	'template_dir' => 'templates/',
	
	// Split on this for Markdown files
	'markdown_split' => "\n%%% CONTENT %%%\n",
	
	// Split on this for sections
	'section_split' => "\n%%% SECTION %%%\n",
);