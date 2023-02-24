<?php

namespace ColdTrick\Poll\Plugins;

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
	 * @return null|Tool[]
	 */
	public static function registerTool(\Elgg\Event $event): ?array {
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
