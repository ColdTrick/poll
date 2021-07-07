<?php

namespace ColdTrick\Poll\Plugins;

class WidgetManager {
	
	/**
	 * Define a widget for a group tool option
	 *
	 * @param \Elgg\Hook $hook 'group_tool_widgets', 'widget_manager'
	 *
	 * @return void|array
	 */
	public static function groupToolWidgets(\Elgg\Hook $hook) {
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggGroup) {
			return;
		}
		
		$return_value = $hook->getValue();
		if (!is_array($return_value)) {
			$return_value = [];
		}
		
		if (!isset($return_value['enable'])) {
			$return_value['enable'] = [];
		}
		if (!isset($return_value['disable'])) {
			$return_value['disable'] = [];
		}
		
		if (poll_is_enabled_for_group($entity)) {
			$return_value['enable'][] = 'recent_polls';
		} else {
			$return_value['disable'][] = 'recent_polls';
			$return_value['disable'][] = 'single_poll';
		}
		
		return $return_value;
	}
}
