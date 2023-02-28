<?php

namespace ColdTrick\Poll\Plugins;

use Elgg\Collections\Collection;
use Elgg\Groups\Tool;

/**
 * Support for the groups plugin
 */
class Groups {
	
	/**
	 * Register a group tool
	 *
	 * @param \Elgg\Event $event 'tool_options', 'group'
	 *
	 * @return null|Collection
	 */
	public static function registerTool(\Elgg\Event $event): ?Collection {
		if (!poll_is_enabled_for_group()) {
			return null;
		}
		
		$result = $event->getValue();
		
		$result[] = new Tool('poll', [
			'default_on' => false,
		]);
		
		return $result;
	}
}
