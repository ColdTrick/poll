<?php

elgg_entity_gatekeeper(elgg_extract('guid', $vars), 'group');
elgg_group_tool_gatekeeper('poll');

/* @var $page_owner \ELggGroup */
$page_owner = get_entity(elgg_extract('guid', $vars));

// breadcrumb
elgg_push_collection_breadcrumbs('object', Poll::SUBTYPE, $page_owner);

if (poll_is_enabled_for_container($page_owner)) {
	elgg_register_title_button('poll', 'add', 'object', Poll::SUBTYPE);
}

// build page elements
$title = elgg_echo('poll:owner:title', [$page_owner->getDisplayName()]);

$contents = elgg_list_entities([
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'container_guid' => $page_owner->guid,
	'preload_owners' => true,
	'no_results' => elgg_echo('poll:none'),
]);

// draw page
echo elgg_view_page($title, [
	'content' => $contents,
]);
