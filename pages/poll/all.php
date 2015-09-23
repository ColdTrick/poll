<?php

// breadcrumb
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('poll:menu:site'));

if (poll_get_plugin_setting('enable_site') === 'yes') {
	elgg_register_title_button();
}

// build page elements
$title = elgg_echo('poll:all:title');

$options = [
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'no_results' => elgg_echo('poll:none'),
	'preload_owners' => true,
	'preload_containers' => true,
];

$contents = elgg_list_entities($options);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $contents
]);

// draw page
echo elgg_view_page($title, $page_data);
