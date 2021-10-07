<?php

namespace ColdTrick\Poll;

class Permissions {
	
	/**
	 * Is the poll feature enabled for site/personal use
	 *
	 * @param \Elgg\Hook $hook 'container_logic_check', 'object'
	 *
	 * @return void|bool
	 */
	public static function enabledForSite(\Elgg\Hook $hook) {
		$container = $hook->getParam('container');
		$subtype = $hook->getParam('subtype');
		if (!$container instanceof \ElggUser || $subtype !== \Poll::SUBTYPE) {
			return;
		}
		
		return elgg_get_plugin_setting('enable_site', 'poll') === 'yes';
	}
	
	/**
	 * Is the poll feature enabled for groups
	 *
	 * @param \Elgg\Hook $hook 'container_logic_check', 'object'
	 *
	 * @return void|bool
	 */
	public static function enabledForGroups(\Elgg\Hook $hook) {
		$container = $hook->getParam('container');
		$subtype = $hook->getParam('subtype');
		if (!$container instanceof \ElggGroup || $subtype !== \Poll::SUBTYPE) {
			return;
		}
		
		return poll_is_enabled_for_group($container);
	}
	
	/**
	 * Check if a user can write a poll in a group
	 *
	 * @param \Elgg\Hook $hook 'container_permissions_check', 'all'
	 *
	 * @return void|bool
	 */
	public static function canWriteContainer(\Elgg\Hook $hook) {
		
		if ($hook->getType() !== 'object' || $hook->getParam('subtype') !== \Poll::SUBTYPE) {
			return;
		}
		
		$user = $hook->getUserParam();
		$container = $hook->getParam('container');
		if (!$user instanceof \ElggUser || !$container instanceof \ElggGroup) {
			return;
		}
		
		// site admin or group owner/admin?
		if ($container->canEdit($user->guid)) {
			return true;
		}
		
		if (!$container->isMember($user)) {
			return false;
		}
		
		// get default site group setting
		$default_setting = 'yes';
		if (elgg_get_plugin_setting('group_create', 'poll') === 'owners') {
			$default_setting = 'no';
		}
		
		// check group setting
		$poll_enable_group_members = $container->getPluginSetting('poll', 'enable_group_members', $default_setting);
		
		return $poll_enable_group_members === 'yes';
	}
}
