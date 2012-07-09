<?php

class SimpleCache {

	// Cache expiration and folder for cached files
	public $cache_expires, $cache_folder;
	
	// Include query strings to make the cached page file unique
	public $include_query_strings = true;
	
	// The current cache file, this will get set when loaded
	private $cache_file = "";
	
	/**
	* Set the current cache file from the page URL
	*/
	public function __construct() {
		
		$this->cache_expires = get_option('php_cache') * 60 * 60 * 24;
		
		$this->cache_folder = get_option('php_cache_dir');

		$file = $_SERVER['REQUEST_URI'];
		if (!$this->include_query_strings && strpos($file, "?") !== false) {
			$qs = explode("?", $file);
			$file = $qs[0];
		}
		
		$this->cache_file = $this->cache_folder . md5($file) . ".html";

	}
	
	/**
	* Checks whether the page has been cached or not
	* @return boolean
	*/
	
	public function is_cached() {
		if ($this->cache_expires > 0) :
			$cached = file_exists($this->cache_file);
		else :
			$modified = (file_exists($this->cache_file)) ? filemtime($this->cache_file) : 0;
			$cached = (time() - $this->cache_expires) < $modified;
		endif;
		return $cached;
	}

	
	/**
	* Reads from the cache file
	* @return string the file contents
	*/
	public function read_cache() {
		return file_get_contents($this->cache_file);
	}
	
	/**
	* Writes to the cache file
	* @param string $contents the contents
	* @return boolean
	*/
	public function write_cache($contents) {
		return file_put_contents($this->cache_file, $contents);
	}
}