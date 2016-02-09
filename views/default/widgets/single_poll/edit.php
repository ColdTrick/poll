<?php

$widget = elgg_extract('entity', $vars);

$poll_guid = $widget->poll_guid;
if (is_array($poll_guid)) {
	$poll_guid = $poll_guid[0];
}

if (elgg_view_exists('input/objectpicker')) {
	$input = elgg_format_element('label', [], elgg_echo('poll:widgets:single_poll:poll_guid:object'));
	
	$input .= elgg_view('input/objectpicker', [
		'name' => 'params[poll_guid]',
		'values' => $widget->poll_guid,
		'subtype' => 'poll',
		'limit' => 1,
	]);
} else {
	$input = elgg_format_element('label', [], elgg_echo('poll:widgets:single_poll:poll_guid:guid'));
	
	$input .= elgg_view('input/text', [
		'name' => 'params[poll_guid]',
		'value' => $widget->poll_guid,
	]);
}

echo elgg_format_element('div', [], $input);