<?php

namespace ColdTrick\Poll\Plugins;

use ColdTrick\Poll\Plugins\EntityTools\MigratePoll;

/**
 * Support for the entity_tools plugin
 */
class EntityTools {
	
	/**
	 * Add questions to the supported types for EntityTools
	 *
	 * @param \Elgg\Event $event 'supported_types', 'entity_tools'
	 *
	 * @return array
	 */
	public static function registerPoll(\Elgg\Event $event): array {
		$return_value = $event->getValue();
		
		$return_value[\Poll::SUBTYPE] = MigratePoll::class;
		
		return $return_value;
	}
}
