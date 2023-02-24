<?php

elgg_require_js('forms/poll/edit');

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => elgg_extract('guid', $vars),
]);

// title
echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'title',
	'value' => elgg_extract('title', $vars),
	'required' => true,
]);

// description
echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('description'),
	'name' => 'description',
	'value' => elgg_extract('description', $vars),
]);

// answers
$answers = elgg_view('elements/forms/label', [
	'label' => elgg_echo('poll:edit:answers'),
	'required' => true,
]);
$answers .= elgg_view('poll/edit/answers', $vars);
echo elgg_format_element('div', [], $answers);

// close date
echo elgg_view_field([
	'#type' => 'date',
	'#label' => elgg_echo('poll:edit:close_date'),
	'name' => 'close_date',
	'value' => elgg_extract('close_date', $vars),
	'timestamp' => true,
	'required' => (bool) (elgg_get_plugin_setting('close_date_required', 'poll') === 'yes'),
]);

// tags
echo elgg_view_field([
	'#type' => 'tags',
	'#label' => elgg_echo('tags'),
	'name' => 'tags',
	'value' => elgg_extract('tags', $vars),
]);

// results output
echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('poll:edit:results_output'),
	'name' => 'results_output',
	'options_values' => [
		'pie' => elgg_echo('poll:edit:results_output:pie'),
		'bar' => elgg_echo('poll:edit:results_output:bar'),
	],
	'value' => elgg_extract('results_output', $vars),
]);

// comments
echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('comments'),
	'name' => 'comments_allowed',
	'checked' => elgg_extract('comments_allowed', $vars) === 'yes',
	'switch' => true,
	'default' => 'no',
	'value' => 'yes',
]);

// access
echo elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('access'),
	'name' => 'access_id',
	'value' => elgg_extract('access_id', $vars),
	'entity' => elgg_extract('entity', $vars),
	'entity_type' => 'object',
	'entity_subtype' => \Poll::SUBTYPE,
]);

echo elgg_view_field([
	'#type' => 'container_guid',
	'entity_type' => 'object',
	'entity_subtype' => \Poll::SUBTYPE,
	'value' => elgg_extract('container_guid', $vars),
]);

// footer
$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);
elgg_set_form_footer($footer);
