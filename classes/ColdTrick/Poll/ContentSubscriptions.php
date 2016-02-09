<?php

namespace ColdTrick\Poll;

class ContentSubscriptions {
	
	/**
	 * Add poll as an supported type for content subscriptions
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function registerEntityType($hook, $type, $return_value, $params) {
		
		if (!is_array($return_value)) {
			// someone removed all
			return;
		}
		
		$return_value['object'][] = 'poll';
		
		return $return_value;
	}
}
