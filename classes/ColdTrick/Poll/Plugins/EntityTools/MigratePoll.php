<?php

namespace ColdTrick\Poll\Plugins\EntityTools;

use ColdTrick\EntityTools\Migrate;

/**
 * Support entity_tools migration
 */
class MigratePoll extends Migrate {
	
	/**
	 * {@inheritdoc}
	 */
	public function canBackDate(): bool {
		return true;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canChangeOwner(): bool {
		return true;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canChangeContainer(): bool {
		return true;
	}
}
