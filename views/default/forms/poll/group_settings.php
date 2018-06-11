<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof ElggGroup)) {
	return;
}

if (!poll_is_enabled_for_container($entity)) {
	return;
}

$value = $entity->getPrivateSetting('poll_enable_group_members');
if (empty($value)) {
	if (elgg_get_plugin_setting('group_create', 'poll') === 'owners') {
		$value = 'no';
	}
}

// enable group members
echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('poll:group_settings:members'),
	'#help' => elgg_echo('poll:group_settings:members:description'),
	'name' => 'poll_enable_group_members',
	'value' => $value,
	'options_values' => [
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	],
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'group_guid',
	'value' => $entity->guid,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);
