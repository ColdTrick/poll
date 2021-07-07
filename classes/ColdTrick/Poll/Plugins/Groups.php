<?php

namespace ColdTrick\Poll\Plugins;

use Elgg\Groups\Tool;

class Groups {
	
	/**
	 * Register a group tool
	 *
	 * @param \Elgg\Hook $hook 'tool_options', 'group'
	 *
	 * @return void|Tool[]
	 */
	public static function registerTool(\Elgg\Hook $hook) {
		
		if (!poll_is_enabled_for_group()) {
			return;
		}
		
		$result = $hook->getValue();
		
		$result[] = new Tool('poll', [
			'label' => elgg_echo('poll:group_tool:title'),
			'default_on' => false,
		]);
		
		return $result;
	}
}
