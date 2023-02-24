<?php

namespace ColdTrick\Poll;

/**
 * Change widget settings
 */
class Widgets {
	
	/**
	 * Set the widget title url
	 *
	 * @param \Elgg\Event $event 'entity:url', 'object'
	 *
	 * @return null|string
	 */
	public static function widgetUrls(\Elgg\Event $event): ?string {
		if (!empty($event->getValue())) {
			// someone already made an url
			return null;
		}
		
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggWidget) {
			return null;
		}
		
		switch ($entity->handler) {
			case 'recent_polls':
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
		}
		
		return null;
	}
}
