<?php

/* @var $page_owner \ElggUser */
$page_owner = elgg_get_page_owner_entity();

// breadcrumb
elgg_push_collection_breadcrumbs('object', \Poll::SUBTYPE, $page_owner);

if (poll_is_enabled_for_container($page_owner)) {
	elgg_register_title_button('add', 'object', \Poll::SUBTYPE);
}

// draw page
echo elgg_view_page(elgg_echo('poll:owner:title', [$page_owner->getDisplayName()]), [
	'content' => elgg_view('poll/listing/owner', [
		'entity' => $page_owner,
	]),
	'filter_value' => ($page_owner->guid === elgg_get_logged_in_user_guid()) ? 'mine' : 'none',
]);
