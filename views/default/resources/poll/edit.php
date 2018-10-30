<?php

elgg_gatekeeper();

// verify input
$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

$entity = get_entity($guid);
if (!$entity->canEdit()) {
	throw new \Elgg\EntityPermissionsException();
}

// breadcrumb
elgg_push_entity_breadcrumbs($entity);

// build page elements
$title = elgg_echo('poll:edit:title', [$entity->getDisplayName()]);

$body_vars = poll_prepare_form_vars($entity);
$content = elgg_view_form('poll/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title, $page_data);
