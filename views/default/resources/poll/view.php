<?php

/* @var $entity \Poll */
$entity = elgg_entity_gatekeeper((int) elgg_extract('guid', $vars), 'object', \Poll::SUBTYPE);

elgg_push_entity_breadcrumbs($entity);

echo elgg_view_page($entity->getDisplayName(), [
	'content' => elgg_view_entity($entity),
	'entity' => $entity,
	'filter_id' => 'poll/view',
]);
