<?php

namespace ColdTrick\Poll;

use Elgg\Notifications\NotificationEventHandler;

/**
 * Notification handler for the creation of a Poll
 */
class CreatePollNotificationHandler extends NotificationEventHandler {
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSubject(\ElggUser $recipient, string $method): string {
		return elgg_echo('poll:notification:create:subject', [$this->event->getObject()->getDisplayName()], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSummary(\ElggUser $recipient, string $method): string {
		return elgg_echo('poll:notification:create:summary', [$this->event->getObject()->getDisplayName()], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationBody(\ElggUser $recipient, string $method): string {
		$entity = $this->event->getObject();
		$actor = $this->event->getActor();
		
		return elgg_echo('poll:notification:create:body', [
			$actor->getDisplayName(),
			$entity->getDisplayName(),
			elgg_get_excerpt((string) $entity->description),
			$entity->getURL(),
		], $recipient->getLanguage());
	}
		
	/**
	 * {@inheritdoc}
	 */
	protected static function isConfigurableForGroup(\ElggGroup $group): bool {
		return $group->isToolEnabled('poll');
	}
}
