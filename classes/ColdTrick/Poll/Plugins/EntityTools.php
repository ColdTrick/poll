<?php

namespace ColdTrick\Poll\Plugins;

use ColdTrick\Poll\Plugins\EntityTools\MigratePoll;

class EntityTools {
	
	/**
	 * Add questions to the supported types for EntityTools
	 *
	 * @param \Elgg\Hook $hook 'supported_types', 'entity_tools'
	 *
	 * @return array
	 */
	public static function registerPoll(\Elgg\Hook $hook) {
		
		$return_value = $hook->getValue();
		$return_value[\Poll::SUBTYPE] = MigratePoll::class;
		
		return $return_value;
	}
}
