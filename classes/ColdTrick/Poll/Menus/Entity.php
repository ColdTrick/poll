<?php

namespace ColdTrick\Poll\Menus;

use Elgg\Menu\MenuItems;

class Entity {
	
	/**
	 * Add a menu item to poll entity menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:entity'
	 *
	 * @return void|MenuItems
	 */
	public static function register(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \Poll || !$entity->canEdit()) {
			return;
		}
		
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'export',
			'icon' => 'download',
			'text' => elgg_echo('export'),
			'href' => elgg_generate_action_url('poll/export', [
				'guid' => $entity->guid,
			]),
		]);
		
		return $return_value;
	}
}
