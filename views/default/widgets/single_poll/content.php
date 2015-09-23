<?php

$widget = elgg_extract('entity', $vars);

$poll_guid = (int) $widget->poll_guid;

$poll = get_entity($poll_guid);

if (!($poll instanceof Poll)) {
	echo elgg_echo('poll:widgets:single_poll:misconfigured');
	return;
}

echo elgg_view_entity($poll);