<?php

namespace ColdTrick\Poll\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the site menu
 */
class Site {
	
	/**
	 * Add a menu item to the site menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:site'
	 *
	 * @return MenuItems
	 */
	public static function register(\Elgg\Event $event): MenuItems {
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'poll',
			'icon' => 'chart-pie',
			'text' => elgg_echo('poll:menu:site'),
			'href' => elgg_generate_url('default:object:poll'),
		]);
		
		return $return_value;
	}
}
