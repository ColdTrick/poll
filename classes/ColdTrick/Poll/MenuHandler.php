<?php

namespace ColdTrick\Poll;

class MenuHandler {
	
	/**
	 * Add a menu item to the site menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:site'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function siteMenu(\Elgg\Hook $hook) {
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'poll',
			'text' => elgg_echo('poll:menu:site'),
			'href' => 'poll/all',
			'icon' => 'chart-pie',
		]);
		
		return $return_value;
	}
	
	/**
	 * Add a menu item to user owner block menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:owner_block'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function userOwnerBlock(\Elgg\Hook $hook) {
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggUser) {
			return;
		}
		
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'poll',
			'text' => elgg_echo('poll:menu:site'),
			'href' => "poll/owner/{$entity->username}",
		]);
		
		return $return_value;
	}
	
	/**
	 * Add a menu item to group owner block menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:owner_block'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupOwnerBlock(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggGroup) {
			return;
		}
		
		if (!poll_is_enabled_for_group($entity)) {
			return;
		}
		
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'poll',
			'text' => elgg_echo('poll:menu:owner_block:group'),
			'href' => "poll/group/{$entity->guid}/all",
		]);
		
		return $return_value;
	}
		
	/**
	 * Add a menu item to poll entity menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:entity'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function entityMenu(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		if (!($entity instanceof \Poll) || !$entity->canEdit()) {
			return;
		}
		
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'export',
			'icon' => 'download',
			'text' => elgg_echo('export'),
			'href' => elgg_http_add_url_query_elements('action/poll/export', [
				'guid' => $entity->guid,
			]),
			'is_action' => true,
		]);
		
		return $return_value;
	}
}
