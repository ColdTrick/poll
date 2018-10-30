<?php

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner instanceof ElggUser) {
	forward(REFERER);
}

// breadcrumb
elgg_push_collection_breadcrumbs('object', Poll::SUBTYPE, $page_owner, true);

if (poll_is_enabled_for_container($page_owner)) {
	elgg_register_title_button('poll', 'add', 'object', Poll::SUBTYPE);
}

$title = elgg_echo('poll:friends:title');

$contents = elgg_list_entities([
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'relationship' => 'friend',
	'relationship_guid' => $page_owner->guid,
	'relationship_join_on' => 'owner_guid',
	'no_results' => elgg_echo('poll:none'),
	'preload_owners' => true,
	'preload_containers' => true,
]);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $contents,
	'filter_context' => 'friends',
]);

// draw page
echo elgg_view_page($title, $page_data);
