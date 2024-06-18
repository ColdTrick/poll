<?php

namespace ColdTrick\Poll\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the entity menu
 */
class Entity {
	
	/**
	 * Add a menu item to poll entity menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \Poll || !$entity->canEdit()) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'export',
			'icon' => 'download',
			'text' => elgg_echo('export'),
			'href' => elgg_generate_action_url('poll/export', [
				'guid' => $entity->guid,
			]),
		]);
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'clear_votes',
			'icon' => 'sync-alt',
			'text' => elgg_echo('poll:votes:clear'),
			'confirm' => true,
			'href' => elgg_generate_action_url('poll/clear_votes', [
				'guid' => $entity->guid,
			]),
		]);
		
		return $return_value;
	}
}
