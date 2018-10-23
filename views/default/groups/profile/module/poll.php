<?php
/**
 * Group poll module
 */

/* @var $group \ElggGroup */
$group = elgg_extract('entity', $vars);

$all_link = elgg_view('output/url', [
	'href' => elgg_generate_url('collection:object:poll:group', [
		'guid' => $group->guid,
	]),
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
]);

elgg_push_context('widgets');
$options = [
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'container_guid' => $group->guid,
	'limit' => 6,
	'pagination' => false,
	'no_results' => elgg_echo('poll:none'),
	'preload_owners' => true,
];
$content = elgg_list_entities($options);
elgg_pop_context();

$new_link = elgg_view('output/url', [
	'href' => elgg_generate_url('add:object:poll', [
		'guid' => $group->guid,
	]),
	'text' => elgg_echo('poll:add'),
	'is_trusted' => true,
]);

echo elgg_view('groups/profile/module', [
	'title' => elgg_echo('poll:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
]);
