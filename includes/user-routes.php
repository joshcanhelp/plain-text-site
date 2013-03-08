<?php

$user_routes_path = dirname(__FILE__) . '/user-contact.php';
if (file_exists($user_routes_path)) 
	require_once($user_routes_path);