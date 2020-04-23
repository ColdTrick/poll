<?php

// verify input
$guid = (int) elgg_extract('guid', $vars);
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

// draw page
echo elgg_view_page($title, [
	'content' => $content,
]);
