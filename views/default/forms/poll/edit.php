<?php

// get supplied arguments
$entity = elgg_extract('entity', $vars);
$container = elgg_extract('container', $vars);

// build form elements
// title
$title = elgg_format_element('label', ['for' => 'poll-title'], elgg_echo('title'));
$title .= elgg_view('input/text', [
	'name' => 'title',
	'value' => elgg_extract('title', $vars),
	'id' => 'poll-title',
]);
echo elgg_format_element('div', [], $title);

// description
$description = elgg_format_element('label', ['for' => 'poll-description'], elgg_echo('description'));
$description .= elgg_view('input/longtext', [
	'name' => 'description',
	'value' => elgg_extract('description', $vars),
	'id' => 'poll-description',
]);
echo elgg_format_element('div', [], $description);

// tags
$tags = elgg_format_element('label', ['for' => 'poll-tags'], elgg_echo('tags'));
$tags .= elgg_view('input/tags', [
	'name' => 'tags',
	'value' => elgg_extract('tags', $vars),
	'id' => 'poll-tags',
]);
echo elgg_format_element('div', [], $tags);

// access
$access = elgg_format_element('label', ['for' => 'poll-access-id'], elgg_echo('access'));
$access .= elgg_view('input/access', [
	'name' => 'access_id',
	'value' => elgg_extract('access_id', $vars),
	'id' => 'poll-access-id',
	'entity' => $entity,
	'entity_type' => 'object',
	'entity_subtype' => Poll::SUBTYPE,
	'class' => 'mls',
]);
echo elgg_format_element('div', [], $access);

// footer
$footer = elgg_view('input/hidden', [
	'name' => 'guid',
	'value' => elgg_extract('guid', $vars),
]);
$footer .= elgg_view('input/hidden', [
	'name' => 'container_guid',
	'value' => $container->getGUID(),
]);
$footer .= elgg_view('input/submit', [
	'value' => elgg_echo('save'),
]);
echo elgg_format_element('div', ['class' => 'elgg-foot'], $footer);
