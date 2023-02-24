<?php

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);

$poll_guid = $widget->poll_guid;
if (empty($poll_guid)) {
	echo elgg_echo('widgets:not_configured');
	return;
}

echo elgg_list_entities([
	'guids' => $poll_guid,
	'type' => 'object',
	'subtype' => \Poll::SUBTYPE,
	'no_results' => elgg_echo('poll:none'),
	'limit' => 1,
	'pagination' => false,
	'show_poll_tabs' => true,
]);
