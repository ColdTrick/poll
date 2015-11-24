<?php

namespace ColdTrick\Poll;

class Permissions {
	
	/**
	 * Check if a user can write a poll in a group
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|bool
	 */
	public static function canWriteContainer($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$subtype = elgg_extract('subtype', $params);
		if (($type !== 'object') || ($subtype !== \Poll::SUBTYPE)) {
			return;
		}
		
		$user = elgg_extract('user', $params);
		if (!($user instanceof \ElggUser)) {
			return false;
		}
		
		$container = elgg_extract('container', $params);
		if (!($container instanceof \ElggGroup)) {
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
		if ($poll_enable_group_members === 'no') {
			// not for group members
			return false;
		}
		
		return true;
	}
}
