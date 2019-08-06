<?php

namespace ColdTrick\Poll;

class Permissions {
	
	/**
	 * Check if a user can write a poll in a group
	 *
	 * @param \Elgg\Hook $hook 'container_permissions_check', 'all'
	 *
	 * @return void|bool
	 */
	public static function canWriteContainer(\Elgg\Hook $hook) {
		$subtype = $hook->getParam('subtype');
		if (($hook->getType() !== 'object') || ($subtype !== \Poll::SUBTYPE)) {
			return;
		}
		
		$user = $hook->getUserParam();
		if (!$user instanceof \ElggUser) {
			return false;
		}
		
		$container = $hook->getParam('container');
		if (!$container instanceof \ElggGroup) {
			return;
		}
		
		// poll enabled?
		if (!poll_is_enabled_for_container($container)) {
			return false;
		}
		
		// site admin or group owner/admin?
		if ($container->canEdit($user->getGUID())) {
			return true;
		}
		
		if (!$container->isMember($user)) {
			return false;
		}
		
		// check group setting
		$poll_enable_group_members = $container->getPrivateSetting('poll_enable_group_members');
		if (empty($poll_enable_group_members)) {
			if (elgg_get_plugin_setting('group_create', 'poll') === 'owners') {
				$poll_enable_group_members = 'no';
			}
		}
		if ($poll_enable_group_members === 'no') {
			// not for group members
			return false;
		}
		
		return true;
	}
}
