<?php

$plugin = elgg_extract('entity', $vars);

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
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