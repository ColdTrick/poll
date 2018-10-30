<?php

// verify input
$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

$entity = get_entity($guid);

// breadcrumb
elgg_push_entity_breadcrumbs($entity, false);

// build page elements
$title = $entity->getDisplayName();

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title,
	'content' => elgg_view_entity($entity),
	'entity' => $entity,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title, $page_data);
