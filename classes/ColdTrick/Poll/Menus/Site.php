<?php

namespace ColdTrick\Poll\Menus;

use Elgg\Menu\MenuItems;

class Site {
	
	/**
	 * Add a menu item to the site menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:site'
	 *
	 * @return void|MenuItems
	 */
	public static function register(\Elgg\Hook $hook) {
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'poll',
			'icon' => 'chart-pie',
			'text' => elgg_echo('poll:menu:site'),
			'href' => elgg_generate_url('default:object:poll'),
		]);
		
		return $return_value;
	}
}
