<?php

// verify input
$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

/* @var $entity Poll */
$entity = get_entity($guid);

// breadcrumb
elgg_push_entity_breadcrumbs($entity, false);

// build page elements
$title = $entity->getDisplayName();

// draw page
echo elgg_view_page($title, [
	'content' => elgg_view_entity($entity),
	'entity' => $entity,
]);
