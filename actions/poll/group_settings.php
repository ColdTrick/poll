<?php

$group_guid = (int) get_input('group_guid');
$enable_group_members = get_input('poll_enable_group_members', 'yes');

if (empty($group_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$group = get_entity($group_guid);
if (!($group instanceof ElggGroup)) {
	register_error(elgg_echo('save:fail'));
	forward(REFERER);
}

if (!$group->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

// save settings
$group->setPrivateSetting('poll_enable_group_members', $enable_group_members);

system_message(elgg_echo('save:success'));
forward($group->getURL());
