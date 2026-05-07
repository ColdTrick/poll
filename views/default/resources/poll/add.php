<?php

use Elgg\Exceptions\Http\EntityPermissionsException;

$container = elgg_get_page_owner_entity();
if (!$container->canWriteToContainer(0, 'object', \Poll::SUBTYPE)) {
	throw new EntityPermissionsException();
}

elgg_push_collection_breadcrumbs('object', \Poll::SUBTYPE, $container);

echo elgg_view_page(elgg_echo('add:object:poll'), [
	'content' => elgg_view_form('poll/edit', [
		'prevent_double_submit' => false,
		'sticky_enabled' => true,
	]),
	'filter_id' => 'poll/edit',
]);
