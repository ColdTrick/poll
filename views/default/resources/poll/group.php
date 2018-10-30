<?php

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner instanceof ElggGroup) {
	forward(REFERER);
}

elgg_group_tool_gatekeeper('poll');

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

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $contents,
	'filter' => ''
]);

// draw page
echo elgg_view_page($title, $page_data);
