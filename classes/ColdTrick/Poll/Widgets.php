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
}
