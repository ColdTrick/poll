<?php

$page_owner = elgg_get_page_owner_entity();
if (empty($page_owner)) {
	forward(REFERER);
}

// breadcrumb
elgg_push_breadcrumb(elgg_echo('poll:menu:site'), 'poll/all');
elgg_push_breadcrumb($page_owner->name);

if (poll_is_enabled_for_container($page_owner)) {
	
	// check if add button is allowed
	if (can_write_to_container(0, $page_owner->getGUID(), 'object', Poll::SUBTYPE)) {
		elgg_register_title_button();
	}
}

// build page elements
$title = elgg_echo('poll:owner:title', [$page_owner->name]);

$options = [
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'no_results' => elgg_echo('poll:none'),
];
if ($page_owner instanceof ElggUser) {
	$options['owner_guid'] = $page_owner->getGUID();
	$options['preload_containers'] = true;
} elseif ($page_owner instanceof ElggGroup) {
	$options['container_guid'] = $page_owner->getGUID();
	$options['preload_owners'] = true;
}

$contents = elgg_list_entities($options);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $contents,
	'filter' => ($page_owner instanceof ElggGroup) ? '' : null,
	'filter_context' => ($page_owner->getGUID === elgg_get_logged_in_user_guid()) ? 'mine' : '',
]);

// draw page
echo elgg_view_page($title, $page_data);
