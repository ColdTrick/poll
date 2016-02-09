<?php

// get supplied arguments
$entity = elgg_extract('entity', $vars);

elgg_require_js('poll/edit');

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

$results_output_options = [
	'pie' => elgg_echo('poll:edit:results_output:pie'),
	'bar' => elgg_echo('poll:edit:results_output:bar'),
];

// build form elements
// title
$title = elgg_format_element('label', ['for' => 'poll-title'], elgg_echo('title'));
$title .= elgg_view('input/text', [
	'name' => 'title',
	'value' => elgg_extract('title', $vars),
	'id' => 'poll-title',
	'required' => true,
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

// answers
$answers = elgg_format_element('label', [], elgg_echo('poll:edit:answers'));
$answers .= elgg_view('poll/edit/answers', $vars);
echo elgg_format_element('div', [], $answers);

// close date
$answers = elgg_format_element('label', ['for' => 'close_date'], elgg_echo('poll:edit:close_date'));
$answers .= elgg_view('input/date', [
	'name' => 'close_date',
	'value' => elgg_extract('close_date', $vars),
	'timestamp' => true,
	'required' => poll_get_plugin_setting('close_date_required') === 'yes' ? true : false,
]);
echo elgg_format_element('div', [], $answers);

// tags
$tags = elgg_format_element('label', ['for' => 'poll-tags'], elgg_echo('tags'));
$tags .= elgg_view('input/tags', [
	'name' => 'tags',
	'value' => elgg_extract('tags', $vars),
	'id' => 'poll-tags',
]);
echo elgg_format_element('div', [], $tags);

// results output
$comments = elgg_format_element('label', ['for' => 'poll-results-output'], elgg_echo('poll:edit:results_output'));
$comments .= elgg_view('input/select', [
	'name' => 'results_output',
	'options_values' => $results_output_options,
	'value' => elgg_extract('results_output', $vars),
	'id' => 'poll-results-output',
	'class' => 'mls',
]);
echo elgg_format_element('div', [], $comments);

// comments
$comments = elgg_format_element('label', ['for' => 'poll-comments'], elgg_echo('comments'));
$comments .= elgg_view('input/select', [
	'name' => 'comments_allowed',
	'options_values' => $noyes_options,
	'value' => elgg_extract('comments_allowed', $vars),
	'id' => 'poll-comments',
	'class' => 'mls',
]);
echo elgg_format_element('div', [], $comments);

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
	'value' => (int) elgg_extract('guid', $vars),
]);
$footer .= elgg_view('input/hidden', [
	'name' => 'container_guid',
	'value' => (int) elgg_extract('container_guid', $vars),
]);
$footer .= elgg_view('input/submit', [
	'value' => elgg_echo('save'),
]);
echo elgg_format_element('div', ['class' => 'elgg-foot'], $footer);
