<?php

namespace ColdTrick\Poll;

class ContentSubscriptions {
	
	/**
	 * Add poll as an supported type for content subscriptions
	 *
	 * @param \Elgg\Hook $hook 'entity_types', 'content_subscriptions'
	 *
	 * @return void|array
	 */
	public static function registerEntityType(\Elgg\Hook $hook) {
		$return_value = $hook->getValue();
		if (!is_array($return_value)) {
			// someone removed all
			return;
		}
		
		$return_value['object'][] = 'poll';
		
		return $return_value;
	}
}
