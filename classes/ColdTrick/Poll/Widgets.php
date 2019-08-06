<?php

namespace ColdTrick\Poll;

class Widgets {
	
	/**
	 * Set the widget title url
	 *
	 * @param \Elgg\Hook $hook 'entity:url', 'object'
	 *
	 * @return void|string
	 */
	public static function widgetUrls(\Elgg\Hook $hook) {
		if (!empty($hook->getValue())) {
			// someone already made an url
			return;
		}
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggWidget) {
			return;
		}
		
		switch ($entity->handler) {
			case 'recent_polls';
				$owner = $entity->getOwnerEntity();
				
				if ($owner instanceof \ElggUser) {
					return elgg_generate_url('collection:object:poll:owner', [
						'username' => $owner->username
					]);
				} elseif ($owner instanceof \ElggGroup) {
					return elgg_generate_url('collection:object:poll:group', [
						'guid' => $owner->guid,
					]);
				}
				
				return elgg_generate_url('collection:object:poll:all');
			
				break;
			case 'single_poll':
				$poll_guid = (int) $entity->poll_guid;
				if (empty($poll_guid)) {
					break;
				}
				
				$poll = get_entity($poll_guid);
				if (!$poll instanceof \Poll) {
					break;
				}
				
				return $poll->getURL();
				
				break;
		}
	}
	
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
