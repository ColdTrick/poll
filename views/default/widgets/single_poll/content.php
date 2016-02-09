<?php

$widget = elgg_extract('entity', $vars);

$poll_guid = $widget->poll_guid;
if (is_array($poll_guid)) {
	$poll_guid = $poll_guid[0];
}
$poll_guid = sanitise_int($poll_guid);

$poll = get_entity($poll_guid);

if (!($poll instanceof Poll)) {
	echo elgg_echo('poll:widgets:single_poll:misconfigured');
	return;
}

echo elgg_view_entity($poll);