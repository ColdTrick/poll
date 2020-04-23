<?php

use Elgg\EntityPermissionsException;

$page_owner = elgg_get_page_owner_entity();

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

// draw page
echo elgg_view_page($title, [
	'content' => $content,
]);
