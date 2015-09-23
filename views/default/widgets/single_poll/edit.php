<?php

$widget = elgg_extract('entity', $vars);

$input = elgg_format_element('label', [], elgg_echo('poll:widgets:single_poll:poll_guid'));
$input .= elgg_view('input/text', [
	'name' => 'params[poll_guid]',
	'value' => $widget->poll_guid,
]);

echo elgg_format_element('div', [], $input);