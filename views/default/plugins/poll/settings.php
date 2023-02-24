<?php

/* @var $plugin \ElggPlugin */
$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('poll:settings:enable_site'),
	'#help' => elgg_echo('poll:settings:enable_site:info'),
	'name' => 'params[enable_site]',
	'checked' => $plugin->enable_site === 'yes',
	'switch' => true,
	'default' => 'no',
	'value' => 'yes',
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('poll:settings:enable_group'),
	'#help' => elgg_echo('poll:settings:enable_group:info'),
	'name' => 'params[enable_group]',
	'checked' => $plugin->enable_group === 'yes',
	'switch' => true,
	'default' => 'no',
	'value' => 'yes',
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('poll:settings:group_create'),
	'#help' => elgg_echo('poll:settings:group_create:info'),
	'name' => 'params[group_create]',
	'options_values' => [
		'members' => elgg_echo('poll:settings:group_create:options:members'),
		'owners' => elgg_echo('poll:settings:group_create:options:owners'),
	],
	'value' => $plugin->group_create,
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('poll:settings:close_date_required'),
	'#help' => elgg_echo('poll:settings:close_date_required:info'),
	'name' => 'params[close_date_required]',
	'checked' => $plugin->close_date_required === 'yes',
	'switch' => true,
	'default' => 'no',
	'value' => 'yes',
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('poll:settings:vote_change_allowed'),
	'#help' => elgg_echo('poll:settings:vote_change_allowed:info'),
	'name' => 'params[vote_change_allowed]',
	'checked' => $plugin->vote_change_allowed === 'yes',
	'switch' => true,
	'default' => 'no',
	'value' => 'yes',
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('poll:settings:add_vote_to_river'),
	'#help' => elgg_echo('poll:settings:add_vote_to_river:info'),
	'name' => 'params[add_vote_to_river]',
	'checked' => $plugin->add_vote_to_river === 'yes',
	'switch' => true,
	'default' => 'no',
	'value' => 'yes',
]);
