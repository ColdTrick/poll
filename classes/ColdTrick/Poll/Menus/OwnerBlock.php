<?php

namespace ColdTrick\Poll\Menus;

class OwnerBlock {
	
	/**
	 * Add a menu item to user owner block menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:owner_block'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerUser(\Elgg\Hook $hook) {
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggUser) {
			return;
		}
		
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'poll',
			'text' => elgg_echo('poll:menu:site'),
			'href' => elgg_generate_url('collection:object:poll:owner', [
				'username' => $entity->username,
			]),
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
	public static function registerGroup(\Elgg\Hook $hook) {
		
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
			'href' => elgg_generate_url('collection:object:poll:group', [
				'guid' => $entity->guid,
			]),
		]);
		
		return $return_value;
	}
}
