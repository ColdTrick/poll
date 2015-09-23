<?php

elgg_gatekeeper();

// verify input
$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

$entity = get_entity($guid);
if (!$entity->canEdit()) {
	regsiter_error(elgg_echo('poll:edit:error:cant_edit'));
	forward(REFERER);
}

// breadcrumb
elgg_push_breadcrumb($entity->title, $entity->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

// build page elements
$title = elgg_echo('poll:edit:title', [$entity->title]);

$body_vars = poll_prepare_form_vars($entity);
$content = elgg_view_form('poll/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title, $page_data);
