<?php

namespace ColdTrick\Poll\Notifications;

use Elgg\Notifications\NonConfigurableNotificationEventHandler;

/**
 * Send a notification when a Poll is closed
 */
class ClosePollHandler extends NonConfigurableNotificationEventHandler {
	
	/**
	 * Get the Poll from the notification
	 *
	 * @return null|\Poll
	 */
	protected function getPoll(): ?\Poll {
		$entity = $this->event->getObject();
		
		return $entity instanceof \Poll ? $entity : null;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSubscriptions(): array {
		$result = [];
		
		$poll = $this->getPoll();
		if (!$poll instanceof \Poll) {
			return [];
		}
		
		// add the owner
		$owner = $poll->getOwnerEntity();
		if ($owner instanceof \ElggUser) {
			$result[$owner->guid] = array_keys(array_filter($owner->getNotificationSettings()));
		}
		
		// add the participants
		elgg_call(ELGG_IGNORE_ACCESS, function() use (&$result, $poll) {
			$votes = $poll->getAnnotations([
				'annotation_name' => 'vote',
				'limit' => false,
				'batch' => true,
			]);
			
			foreach ($votes as $vote) {
				$participant = $vote->getOwnerEntity();
				if (!$participant instanceof \ElggUser) {
					continue;
				}
				
				$preference = array_keys(array_filter($participant->getNotificationSettings()));
				if (empty($preference)) {
					continue;
				}
				
				$result[$participant->guid] = $preference;
			}
		});
		
		return $result;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSubject(\ElggUser $recipient, string $method): string {
		$poll = $this->getPoll();
		
		if ($recipient->guid === $poll->owner_guid) {
			return elgg_echo('poll:notification:close:owner:subject', [$poll->getDisplayName()]);
		}
		
		return elgg_echo('poll:notification:close:participant:subject', [$poll->getDisplayName()]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSummary(\ElggUser $recipient, string $method): string {
		$poll = $this->getPoll();
		
		if ($recipient->guid === $poll->owner_guid) {
			return elgg_echo('poll:notification:close:owner:summary', [$poll->getDisplayName()]);
		}
		
		return elgg_echo('poll:notification:close:participant:summary', [$poll->getDisplayName()]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationBody(\ElggUser $recipient, string $method): string {
		$poll = $this->getPoll();
		
		if ($recipient->guid === $poll->owner_guid) {
			return elgg_echo('poll:notification:close:owner:body', [
				$poll->getDisplayName(),
				$poll->getURL(),
			]);
		}
		
		return elgg_echo('poll:notification:close:participant:body', [
			$poll->getDisplayName(),
			$poll->getURL(),
		]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationURL(\ElggUser $recipient, string $method): string {
		return (string) $this->getPoll()?->getURL();
	}
}
