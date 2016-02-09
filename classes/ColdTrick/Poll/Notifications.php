<?php

namespace ColdTrick\Poll;

class Notifications {
	
	/**
	 * Change the notification contents
	 *
	 * @param string                           $hook         the name of the hook
	 * @param string                           $type         the type of the hook
	 * @param \Elgg\Notifications\Notification $return_value current return value
	 * @param array                            $params       supplied params
	 *
	 * @return void|\Elgg\Notifications\Notification
	 */
	public static function createPoll($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$event = elgg_extract('event', $params);
		if (!($event instanceof \Elgg\Notifications\Event)) {
			return;
		}
		
		$entity = $event->getObject();
		$actor = $event->getActor();
		$language = elgg_extract('language', $params);
		
		$return_value->subject = elgg_echo('poll:notification:create:subject', [$entity->title], $language);
		$return_value->summary = elgg_echo('poll:notification:create:summary', [$entity->title], $language);
		$return_value->body = elgg_echo('poll:notification:create:body', [
			$actor->name,
			$entity->title,
			elgg_get_excerpt($entity->description),
			$entity->getURL(),
		], $language);
		
		return $return_value;
	}
	
	/**
	 * Send out notifications when a poll is 'closed'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void
	 */
	public static function closeCron($hook, $type, $return_value, $params) {
		
		$time = mktime(0, 0, 0);
		
		$options = [
			'type' => 'object',
			'subtype' => \Poll::SUBTYPE,
			'limit' => false,
			'metadata_name_value_pairs' => [
				[
					'name' => 'close_date',
					'value' => $time - (24 * 60 * 60), // past 24 hours
					'operand' => '>'
				],
				[
					'name' => 'close_date',
					'value' => $time, // today 0h:0m:0s
					'operand' => '<='
				],
			],
		];
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		$batch = new \ElggBatch('elgg_get_entities_from_metadata', $options);
		foreach ($batch as $poll) {
			
			if (!($poll instanceof \Poll)) {
				continue;
			}
			
			// notify owner
			$poll->notifyOwnerOnClose();
			
			// notify participants
			$poll->notifyParticipantsOnClose();
		}
		
		// restore access
		elgg_set_ignore_access($ia);
	}
}
