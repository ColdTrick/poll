<?php

elgg_gatekeeper();

$page_owner = elgg_get_page_owner_entity();
if (empty($page_owner)) {
	forward(REFERER);
}

// build page elements
$title = elgg_echo('add');

$body = elgg_view_form('poll/edit', [], ['container' => $page_owner]);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $body,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title, $page_data);
