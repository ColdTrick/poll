<?php

namespace ColdTrick\Poll;

class Notifications {
	
	/**
	 * Change the notification contents
	 *
	 * @param \Elgg\Hook $hook 'prepare', 'notification:create:object:poll'
	 *
	 * @return void|\Elgg\Notifications\Notification
	 */
	public static function createPoll(\Elgg\Hook $hook) {
		
		$event = $hook->getParam('event');
		if (!$event instanceof \Elgg\Notifications\Event) {
			return;
		}
		
		$entity = $event->getObject();
		$actor = $event->getActor();
		$language = $hook->getParam('language');
		
		$return_value = $hook->getValue();
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
	 * @param \Elgg\Hook $hook 'cron', 'daily'
	 *
	 * @return void
	 */
	public static function closeCron(\Elgg\Hook $hook) {
		
		echo 'Starting Poll closed notification' . PHP_EOL;
		elgg_log('Starting Poll closed notification', 'NOTICE');
		
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
		
		echo 'Done with Poll closed notification' . PHP_EOL;
		elgg_log('Done with Poll closed notification', 'NOTICE');
	}
}
