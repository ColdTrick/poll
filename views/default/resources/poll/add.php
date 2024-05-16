<?php

use ColdTrick\Poll\EditForm;
use Elgg\Exceptions\Http\EntityPermissionsException;

$page_owner = elgg_get_page_owner_entity();

// and you're allowed to write to the container
if (!$page_owner->canWriteToContainer(0, 'object', \Poll::SUBTYPE)) {
	throw new EntityPermissionsException();
}

//breadcrumb
elgg_push_collection_breadcrumbs('object', \Poll::SUBTYPE, $page_owner);

// draw page
echo elgg_view_page(elgg_echo('add:object:poll'), [
	'content' => elgg_view_form('poll/edit', [
		'prevent_double_submit' => false,
		'sticky_enabled' => true,
	]),
	'filter_id' => 'poll/edit',
]);
