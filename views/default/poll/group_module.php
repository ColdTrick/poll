<?php
/**
 * Group poll module
 */

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
	return;
}

if (!poll_is_enabled_for_group($group)) {
	return;
}

$all_link = elgg_view('output/url', [
	'href' => "poll/group/{$group->getGUID()}/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
]);

elgg_push_context('widgets');
$options = [
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'container_guid' => $group->getGUID(),
	'limit' => 6,
	'pagination' => false,
	'no_results' => elgg_echo('poll:none'),
	'preload_owners' => true,
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
