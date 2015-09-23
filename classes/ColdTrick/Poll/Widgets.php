<?php

namespace ColdTrick\Poll;

class Widgets {
	
	/**
	 * Set the widget title url
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function widgetUrls($hook, $type, $return_value, $params) {
		
		if (!empty($return_value)) {
			// someone already made an url
			return;
		}
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggWidget)) {
			return;
		}
		
		switch ($entity->handler) {
			case 'recent_polls';
				$owner = $entity->getOwnerEntity();
				
				if ($owner instanceof \ElggUser) {
					return "poll/owner/{$owner->username}";
				} elseif ($owner instanceof \ElggGroup) {
					return "poll/group/{$owner->getGUID()}/all";
				}
				
				return 'poll/all';
			
				break;
			case 'single_poll':
				$poll_guid = (int) $entity->poll_guid;
				if (empty($poll_guid)) {
					break;
				}
				
				$poll = get_entity($poll_guid);
				if (!($poll instanceof \Poll)) {
					break;
				}
				
				return $poll->getURL();
				
				break;
		}
	}
	
	/**
	 * Define a widget for a group tool option
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function groupToolWidgets($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
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
