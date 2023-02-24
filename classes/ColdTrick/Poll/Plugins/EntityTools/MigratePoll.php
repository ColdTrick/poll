<?php

namespace ColdTrick\Poll\Plugins\EntityTools;

use ColdTrick\EntityTools\Migrate;

/**
 * Support entity_tools migration
 */
class MigratePoll extends Migrate {
	
	/**
	 * {@inheritDoc}
	 */
	public function canBackDate(): bool {
		return true;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function canChangeOwner(): bool {
		return true;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function canChangeContainer(): bool {
		return true;
	}
}
