<?php

/* @var $entity \Poll */
$entity = elgg_entity_gatekeeper((int) elgg_extract('guid', $vars), 'object', \Poll::SUBTYPE, true);

elgg_push_entity_breadcrumbs($entity);

echo elgg_view_page(elgg_echo('poll:edit:title', [$entity->getDisplayName()]), [
	'content' => elgg_view_form('poll/edit', [
		'prevent_double_submit' => false,
		'sticky_enabled' => true,
	], [
		'entity' => $entity,
	]),
	'filter_id' => 'poll/edit',
]);
