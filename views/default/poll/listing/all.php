<?php
/**
 * Show a listing of Polls
 *
 * @uses $vars['options'] additional options for the listing
 */

$defaults = [
	'type' => 'object',
	'subtype' => \Poll::SUBTYPE,
	'no_results' => elgg_echo('poll:none'),
	'preload_owners' => true,
	'preload_containers' => true,
];

$options = (array) elgg_extract('options', $vars, []);
$options = array_merge($defaults, $options);

echo elgg_list_entities($options);
