<?php
/**
 * Show a listing of Polls
 *
 * @uses $vars['options'] additional options for the listing
 */

$options = (array) elgg_extract('options', $vars, []);

$defaults = [
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'no_results' => elgg_echo('poll:none'),
	'preload_owners' => true,
	'preload_containers' => true,
];

$options = array_merge($defaults, $options);

echo elgg_list_entities($options);
