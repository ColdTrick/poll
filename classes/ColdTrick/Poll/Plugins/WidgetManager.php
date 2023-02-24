<?php

namespace ColdTrick\Poll\Plugins;

/**
 * Support for the widget_manager plugin
 */
class WidgetManager {
	
	/**
	 * Define a widget for a group tool option
	 *
	 * @param \Elgg\Event $event 'group_tool_widgets', 'widget_manager'
	 *
	 * @return null|array
	 */
	public static function groupToolWidgets(\Elgg\Event $event): ?array {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggGroup) {
			return null;
		}
		
		$return_value = $event->getValue();
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
