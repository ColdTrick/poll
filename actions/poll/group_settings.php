<?php

$group_guid = (int) get_input('group_guid');
$enable_group_members = get_input('poll_enable_group_members', 'yes');

if (empty($group_guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$group = get_entity($group_guid);
if (!($group instanceof ElggGroup)) {
	return elgg_error_response(elgg_echo('save:fail'));
}

if (!$group->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

// save settings
$group->setPrivateSetting('poll_enable_group_members', $enable_group_members);

return elgg_ok_response('', elgg_echo('save:success'), $group->getURL());
