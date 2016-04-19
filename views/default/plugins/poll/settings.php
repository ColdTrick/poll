<?php

$plugin = elgg_extract('entity', $vars);

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

$yesno_options = array_reverse($noyes_options);

$group_create_options = [
	'members' => elgg_echo('poll:settings:group_create:options:members'),
	'owners' => elgg_echo('poll:settings:group_create:options:owners'),
];

echo elgg_format_element('label', [], elgg_echo('poll:settings:enable_site'));
echo elgg_view('input/select', [
	'name' => 'params[enable_site]',
	'options_values' => $noyes_options,
	'value' => $plugin->enable_site,
	'class' => 'mls'
]);
echo elgg_format_element('div', ['class'=> 'elgg-subtext'], elgg_echo('poll:settings:enable_site:info'));

echo elgg_format_element('label', [], elgg_echo('poll:settings:enable_group'));
echo elgg_view('input/select', [
	'name' => 'params[enable_group]',
	'options_values' => $noyes_options,
	'value' => $plugin->enable_group,
	'class' => 'mls'
]);
echo elgg_format_element('div', ['class'=> 'elgg-subtext'], elgg_echo('poll:settings:enable_group:info'));

echo elgg_format_element('label', [], elgg_echo('poll:settings:group_create'));
echo elgg_view('input/select', [
	'name' => 'params[group_create]',
	'options_values' => $group_create_options,
	'value' => $plugin->group_create,
	'class' => 'mls'
]);
echo elgg_format_element('div', ['class'=> 'elgg-subtext'], elgg_echo('poll:settings:group_create:info'));

echo elgg_format_element('label', [], elgg_echo('poll:settings:close_date_required'));
echo elgg_view('input/select', [
	'name' => 'params[close_date_required]',
	'options_values' => $noyes_options,
	'value' => $plugin->close_date_required,
	'class' => 'mls'
]);
echo elgg_format_element('div', ['class'=> 'elgg-subtext'], elgg_echo('poll:settings:close_date_required:info'));

echo elgg_format_element('label', [], elgg_echo('poll:settings:vote_change_allowed'));
echo elgg_view('input/select', [
	'name' => 'params[vote_change_allowed]',
	'options_values' => $yesno_options,
	'value' => $plugin->vote_change_allowed,
	'class' => 'mls'
]);
echo elgg_format_element('div', ['class'=> 'elgg-subtext'], elgg_echo('poll:settings:vote_change_allowed:info'));

echo elgg_format_element('label', [], elgg_echo('poll:settings:add_vote_to_river'));
echo elgg_view('input/select', [
	'name' => 'params[add_vote_to_river]',
	'options_values' => $yesno_options,
	'value' => $plugin->add_vote_to_river,
	'class' => 'mls'
]);
echo elgg_format_element('div', ['class'=> 'elgg-subtext'], elgg_echo('poll:settings:add_vote_to_river:info'));
