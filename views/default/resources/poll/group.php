<?php

elgg_group_tool_gatekeeper('poll');

/* @var $page_owner \ElggGroup */
$page_owner = elgg_get_page_owner_entity();

// breadcrumb
elgg_push_collection_breadcrumbs('object', \Poll::SUBTYPE, $page_owner);

if (poll_is_enabled_for_container($page_owner)) {
	elgg_register_title_button('add', 'object', \Poll::SUBTYPE);
}

// draw page
echo elgg_view_page(elgg_echo('poll:owner:title', [$page_owner->getDisplayName()]), [
	'content' => elgg_view('poll/listing/group', [
		'entity' => $page_owner,
	]),
	'filter_id' => 'poll/group',
]);
