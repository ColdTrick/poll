<?php

use Elgg\EntityPermissionsException;

elgg_gatekeeper();

$page_owner = elgg_get_page_owner_entity();
if (empty($page_owner)) {
	forward(REFERER);
}

// and you're allowed to write to the container
if (!$page_owner->canWriteToContainer(0, 'object', Poll::SUBTYPE)) {
	throw new EntityPermissionsException();
}

//breadcrumb
elgg_push_collection_breadcrumbs('object', Poll::SUBTYPE, $page_owner);

// build page elements
$title = elgg_echo('poll:add');

$body_vars = poll_prepare_form_vars();
$content = elgg_view_form('poll/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title, $page_data);
