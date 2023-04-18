<?php

namespace ColdTrick\Poll;

/**
 * Change user permissions
 */
class Permissions {
	
	/**
	 * Is the poll feature enabled for site/personal use
	 *
	 * @param \Elgg\Event $event 'container_logic_check', 'object'
	 *
	 * @return null|bool
	 */
	public static function enabledForSite(\Elgg\Event $event): ?bool {
		$container = $event->getParam('container');
		$subtype = $event->getParam('subtype');
		if (!$container instanceof \ElggUser || $subtype !== \Poll::SUBTYPE) {
			return null;
		}
		
		return elgg_get_plugin_setting('enable_site', 'poll') === 'yes';
	}
	
	/**
	 * Check if a user can write a poll in a group
	 *
	 * @param \Elgg\Event $event 'container_permissions_check', 'all'
	 *
	 * @return null|bool
	 */
	public static function canWriteContainer(\Elgg\Event $event): ?bool {
		if ($event->getType() !== 'object' || $event->getParam('subtype') !== \Poll::SUBTYPE) {
			return null;
		}
		
		$user = $event->getUserParam();
		$container = $event->getParam('container');
		if (!$user instanceof \ElggUser || !$container instanceof \ElggGroup) {
			return null;
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
		return $container->getPluginSetting('poll', 'enable_group_members', $default_setting) === 'yes';
	}
}
