<?php

elgg_gatekeeper();

$page_owner = elgg_get_page_owner_entity();
if (empty($page_owner)) {
	forward(REFERER);
}

// make sure poll is enabled
poll_container_gatekeeper($page_owner);

//breadcrumb
elgg_push_breadcrumb(elgg_echo('poll:add'));

// build page elements
$title = elgg_echo('poll:add');

$body_vars = poll_prepare_form_vars();
$content = elgg_view_form('poll/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title, $page_data);
