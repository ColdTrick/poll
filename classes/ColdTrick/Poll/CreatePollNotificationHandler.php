<?php

namespace ColdTrick\Poll;

use Elgg\Notifications\NotificationEventHandler;

class CreatePollNotificationHandler extends NotificationEventHandler {
	
	/**
	 * {@inheritDoc}
	 */
	protected function getNotificationSubject(\ElggUser $recipient, string $method): string {
		return elgg_echo('poll:notification:create:subject', [$this->event->getObject()->getDisplayName()], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getNotificationSummary(\ElggUser $recipient, string $method): string {
		return elgg_echo('poll:notification:create:summary', [$this->event->getObject()->getDisplayName()], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getNotificationBody(\ElggUser $recipient, string $method): string {
		$entity = $this->event->getObject();
		$actor = $this->event->getActor();
		
		return elgg_echo('poll:notification:create:body', [
			$actor->getDisplayName(),
			$entity->getDisplayName(),
			elgg_get_excerpt($entity->description),
			$entity->getURL(),
		], $recipient->getLanguage());
	}
		
	/**
	 * {@inheritDoc}
	 */
	protected static function isConfigurableForGroup(\ElggGroup $group): bool {
		return $group->isToolEnabled('poll');
	}
}
