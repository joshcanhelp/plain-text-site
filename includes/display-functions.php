<?php

function display_sub_pages($subs) {
	
	global $query;
	
	$out = '';
	
	if (!is_array($subs) || empty($subs)) return $out;
	
	foreach ($subs as $sub) :
		
		$title = empty($sub['title']) ? 'Untitled...' : $sub['title'];
		$desc = empty($sub['description']) ? '<p>' : '' . $sub['description'] . '</p>';
		$link = empty($sub['path']) ? '#no-link' : $query['base'] . $sub['path'];
		
		$out .= '
		<div class="sub-page-wrap">
			<h2><a href="'.$link.'">'.$title.'</a></h2>
			'.$desc.'
		</div>';
		
	endforeach;
	
	return $out;
	
}


/*
Takes a formatted array and returns menu HTML
*/
function display_nav_menu ($menu) {
	
	global $query;
	
	$out = '';
	
	if (!is_array($menu) || empty($menu)) return $out;
	
	$out .= '
	<ul id="main-nav">';
	
	foreach ($menu as $key => $val) :
		$out .= '
		<li><a href="' . $query['base'] . $val . '">'.$key.'</a></li>';
	endforeach;
	
	$out .= '
	</ul>';
	
	return $out;
	
}