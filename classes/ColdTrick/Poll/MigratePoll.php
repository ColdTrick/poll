<?php

namespace ColdTrick\Poll;

use ColdTrick\EntityTools\Migrate;

class MigratePoll extends Migrate {
	
	/**
	 * Add questions to the supported types for EntityTools
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param mixed  $params       supplied params
	 *
	 * @return array
	 */
	public static function supportedSubtypes($hook, $type, $return_value, $params) {
		
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
