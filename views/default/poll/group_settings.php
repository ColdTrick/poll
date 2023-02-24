<?php

if (elgg_get_plugin_setting('enable_group', 'poll') === 'no') {
	return;
}

$value = null;
if (elgg_get_plugin_setting('group_create', 'poll') === 'owners') {
	$value = 'no';
}

$group = elgg_extract('entity', $vars);
if ($group instanceof \ElggGroup) {
	$value = $group->getPluginSetting('poll', 'enable_group_members', $value);
}

// enable group members
$content = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('poll:group_settings:members'),
	'#help' => elgg_echo('poll:group_settings:members:description'),
	'name' => 'settings[poll][enable_group_members]',
	'value' => $value,
	'options_values' => [
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	],
]);

echo elgg_view_module('info', elgg_echo('poll:group_settings:title'), $content);
