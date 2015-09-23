<?php

// verify input
$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

$entity = get_entity($guid);

// build page elements
$title = $entity->title;

$content = elgg_view_entity($entity);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title, $page_data);