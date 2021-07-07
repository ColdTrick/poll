<?php

use Elgg\Exceptions\Http\EntityNotFoundException;

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner instanceof ElggUser) {
	throw new EntityNotFoundException();
}

// breadcrumb
elgg_push_collection_breadcrumbs('object', Poll::SUBTYPE, $page_owner, true);

if (poll_is_enabled_for_container($page_owner)) {
	elgg_register_title_button('poll', 'add', 'object', Poll::SUBTYPE);
}

// draw page
echo elgg_view_page(elgg_echo('poll:friends:title'), [
	'content' => elgg_view('poll/listing/friends', ['entity' => $page_owner]),
	'filter_value' => 'friends',
]);
