<?php
/**
 * Group poll module
 */

$group = elgg_get_page_owner_entity();

if ($group->poll_enable !== "yes") {
	return true;
}

$all_link = elgg_view('output/url', [
	'href' => "poll/group/{$group->getGUID()}/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
]);

elgg_push_context('widgets');
$options = [
	'type' => 'object',
	'subtype' => 'poll',
	'container_guid' => $group->getGUID(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
	'no_results' => elgg_echo('poll:none'),
	'distinct' => false,
];
$content = elgg_list_entities($options);
elgg_pop_context();

$new_link = elgg_view('output/url', [
	'href' => "poll/add/{$group->getGUID()}",
	'text' => elgg_echo('poll:add'),
	'is_trusted' => true,
]);

echo elgg_view('groups/profile/module', [
	'title' => elgg_echo('poll:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
]);
