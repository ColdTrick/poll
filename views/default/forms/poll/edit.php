<?php

// get supplied arguments
$entity = elgg_extract('entity', $vars);

elgg_require_js('poll/edit');

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

// build form elements
// title
echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'title',
	'value' => elgg_extract('title', $vars),
	'id' => 'poll-title',
	'required' => true,
]);

// description
echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('description'),
	'name' => 'description',
	'value' => elgg_extract('description', $vars),
	'id' => 'poll-description',
]);

// answers
$answers = elgg_view('elements/forms/label', ['label' => elgg_echo('poll:edit:answers'), 'required' => true]);;
$answers .= elgg_view('poll/edit/answers', $vars);
echo elgg_format_element('div', [], $answers);

// close date
echo elgg_view_field([
	'#type' => 'date',
	'#label' => elgg_echo('poll:edit:close_date'),
	'name' => 'close_date',
	'value' => elgg_extract('close_date', $vars),
	'timestamp' => true,
	'required' => poll_get_plugin_setting('close_date_required') === 'yes' ? true : false,
]);

// tags
echo elgg_view_field([
	'#type' => 'tags',
	'#label' => elgg_echo('tags'),
	'id' => 'poll-tags',
	'name' => 'tags',
	'value' => elgg_extract('tags', $vars),
]);

// results output
echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('poll:edit:results_output'),
	'id' => 'poll-results-output',
	'name' => 'results_output',
	'options_values' => [
		'pie' => elgg_echo('poll:edit:results_output:pie'),
		'bar' => elgg_echo('poll:edit:results_output:bar'),
	],
	'value' => elgg_extract('results_output', $vars),
]);

// comments
echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('comments'),
	'id' => 'poll-comments',
	'name' => 'comments_allowed',
	'options_values' => $noyes_options,
	'value' => elgg_extract('comments_allowed', $vars),
]);

// access
echo elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('access'),
	'name' => 'access_id',
	'value' => elgg_extract('access_id', $vars),
	'id' => 'poll-access-id',
	'entity' => $entity,
	'entity_type' => 'object',
	'entity_subtype' => Poll::SUBTYPE,
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => (int) elgg_extract('guid', $vars),
]);
echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'container_guid',
	'value' => (int) elgg_extract('container_guid', $vars),
]);

// footer
$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);
elgg_set_form_footer($footer);
