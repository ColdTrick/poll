<?php

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
	return;
}

if (!poll_is_enabled_for_container($group)) {
	return;
}

$title = elgg_echo('poll:group_settings:title');

$content = elgg_view_form('poll/group_settings', [], ['entity' => $group]);

echo elgg_view_module('info', $title, $content);
