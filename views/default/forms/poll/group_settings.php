<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof ElggGroup)) {
	return;
}

if (!poll_is_enabled_for_container($entity)) {
	return;
}

$yesno_options = [
	'yes' => elgg_echo('option:yes'),
	'no' => elgg_echo('option:no'),
];

$value = $entity->getPrivateSetting('poll_enable_group_members');
if (empty($value)) {
	if (elgg_get_plugin_setting('group_create', 'poll') === 'owners') {
		$value = 'no';
	}
}

// enable group members
$members = elgg_echo('poll:group_settings:members');
$members .= elgg_view('input/select', [
	'name' => 'poll_enable_group_members',
	'value' => $value,
	'options_values' => $yesno_options,
	'class' => 'mls',
]);
$members .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('poll:group_settings:members:description'));

echo elgg_format_element('div', [], $members);

// form footer
$footer = elgg_view('input/hidden', [
	'name' => 'group_guid',
	'value' => $entity->getGUID(),
]);
$footer .= elgg_view('input/submit', [
	'value' => elgg_echo('save'),
]);

echo elgg_format_element('div', ['class' => 'elgg-foot'], $footer);
