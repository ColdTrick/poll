<?php

use ColdTrick\Poll\EditForm;

// verify input
$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', \Poll::SUBTYPE, true);

/* @var $entity \Poll */
$entity = get_entity($guid);

// breadcrumb
elgg_push_entity_breadcrumbs($entity);

// draw page
echo elgg_view_page(elgg_echo('poll:edit:title', [$entity->getDisplayName()]), [
	'content' => elgg_view_form('poll/edit', [
		'prevent_double_submit' => false,
		'sticky_enabled' => true,
	], [
		'entity' => $entity,
	]),
	'filter_id' => 'poll/edit',
]);
