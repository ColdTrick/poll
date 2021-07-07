<?php

if (elgg_get_plugin_setting('enable_site', 'poll') === 'yes') {
	elgg_register_title_button('poll', 'add', 'object', Poll::SUBTYPE);
}

elgg_push_collection_breadcrumbs('object', Poll::SUBTYPE);

// draw page
echo elgg_view_page(elgg_echo('poll:all:title'), [
	'content' => elgg_view('poll/listing/all'),
	'filter_value' => 'all',
]);
