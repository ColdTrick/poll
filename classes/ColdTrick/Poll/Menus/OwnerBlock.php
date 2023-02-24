<?php

namespace ColdTrick\Poll\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the owner_block menu
 */
class OwnerBlock {
	
	/**
	 * Add a menu item to user owner block menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:owner_block'
	 *
	 * @return null|MenuItems
	 */
	public static function registerUser(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggUser) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
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
	 * @param \Elgg\Event $event 'register', 'menu:owner_block'
	 *
	 * @return null|MenuItems
	 */
	public static function registerGroup(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggGroup) {
			return null;
		}
		
		if (!poll_is_enabled_for_group($entity)) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
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
