<?php

namespace ColdTrick\Poll;

/**
 * Cron handler
 */
class Cron {
	
	/**
	 * Send out notifications when a poll is 'closed'
	 *
	 * @param \Elgg\Event $event 'cron', 'daily'
	 *
	 * @return void
	 */
	public static function sendCloseNotifications(\Elgg\Event $event): void {
		echo 'Starting Poll closed notification' . PHP_EOL;
		elgg_log('Starting Poll closed notification', 'NOTICE');
		
		elgg_call(ELGG_IGNORE_ACCESS, function() {
			$time = mktime(0, 0, 0);
			
			$options = [
				'type' => 'object',
				'subtype' => \Poll::SUBTYPE,
				'limit' => false,
				'batch' => true,
				'metadata_name_value_pairs' => [
					[
						'name' => 'close_date',
						'value' => $time - (24 * 60 * 60), // past 24 hours
						'operand' => '>',
						'type' => ELGG_VALUE_INTEGER,
					],
					[
						'name' => 'close_date',
						'value' => $time, // today 0h:0m:0s
						'operand' => '<=',
						'type' => ELGG_VALUE_INTEGER,
					],
				],
			];
			
			/* @var $batch \ElggBatch */
			$batch = elgg_get_entities($options);
			/* @var $poll \Poll */
			foreach ($batch as $poll) {
				if (!$poll instanceof \Poll) {
					continue;
				}
				
				// notify owner
				$poll->notifyOwnerOnClose();
				
				// notify participants
				$poll->notifyParticipantsOnClose();
			}
		});
		
		echo 'Done with Poll closed notification' . PHP_EOL;
		elgg_log('Done with Poll closed notification', 'NOTICE');
	}
}
