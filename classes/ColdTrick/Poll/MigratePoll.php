<?php

namespace ColdTrick\Poll;

use ColdTrick\EntityTools\Migrate;

class MigratePoll extends Migrate {
	
	/**
	 * Add questions to the supported types for EntityTools
	 *
	 * @param \Elgg\Hook $hook 'supported_types', 'entity_tools'
	 *
	 * @return array
	 */
	public static function supportedSubtypes(\Elgg\Hook $hook) {
		
		$return_value = $hook->getValue();
		$return_value[\Poll::SUBTYPE] = self::class;
		return $return_value;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \ColdTrick\EntityTools\Migrate::canBackDate()
	 */
	public function canBackDate() {
		return true;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \ColdTrick\EntityTools\Migrate::canChangeOwner()
	 */
	public function canChangeOwner() {
		return true;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \ColdTrick\EntityTools\Migrate::canChangeContainer()
	 */
	public function canChangeContainer() {
		return true;
	}
}
