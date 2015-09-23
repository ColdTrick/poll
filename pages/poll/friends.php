<?php

$page_owner = elgg_get_page_owner_entity();
if (!($page_owner instanceof ElggUser)) {
	forward(REFERER);
}

// breadcrumb
elgg_push_breadcrumb($page_owner->name, "poll/owner/{$page_owner->username}");
elgg_push_breadcrumb(elgg_echo('poll:friends:title'));

if (poll_is_enabled_for_container($page_owner)) {
	elgg_register_title_button();
}

$title = elgg_echo('poll:friends:title');

$options = [
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'relationship' => 'friend',
	'relationship_guid' => $page_owner->getGUID(),
	'relationship_join_on' => 'owner_guid',
	'no_results' => elgg_echo('poll:none'),
	'preload_owners' => true,
	'preload_containers' => true,
];

$contents = elgg_list_entities_from_relationship($options);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $contents,
	'filter_context' => 'friends',
]);

// draw page
echo elgg_view_page($title, $page_data);