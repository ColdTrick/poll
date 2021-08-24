<?php

use Elgg\Exceptions\Http\EntityPermissionsException;
use ColdTrick\Poll\EditForm;

// verify input
$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

$entity = get_entity($guid);
if (!$entity->canEdit()) {
	throw new EntityPermissionsException();
}

// breadcrumb
elgg_push_entity_breadcrumbs($entity);

// build page elements
$title = elgg_echo('poll:edit:title', [$entity->getDisplayName()]);

$edit = new EditForm($entity);
$content = elgg_view_form('poll/edit', [
	'prevent_double_submit' => false,
], $edit());

// draw page
echo elgg_view_page($title, [
	'content' => $content,
	'filter_id' => 'poll/edit',
]);
