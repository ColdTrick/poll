<?php

// breadcrumb
elgg_push_breadcrumb(elgg_echo('poll:menu:site'));

if (elgg_get_plugin_setting('enable_site', 'poll') === 'yes') {
	elgg_register_title_button();
}

// build page elements
$title = elgg_echo('poll:all:title');

$contents = elgg_list_entities([
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'no_results' => elgg_echo('poll:none'),
	'preload_owners' => true,
	'preload_containers' => true,
]);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $contents
]);

// draw page
echo elgg_view_page($title, $page_data);