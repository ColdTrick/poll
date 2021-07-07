<?php

namespace ColdTrick\Poll\Upgrades;

use Elgg\Upgrade\AsynchronousUpgrade;
use Elgg\Upgrade\Result;

class MigrateGroupSettings implements AsynchronousUpgrade {

	/**
	 * {@inheritDoc}
	 */
	public function getVersion(): int {
		return 2021070701;
	}

	/**
	 * {@inheritDoc}
	 */
	public function needsIncrementOffset(): bool {
		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function shouldBeSkipped(): bool {
		return empty($this->countItems());
	}

	/**
	 * {@inheritDoc}
	 */
	public function countItems(): int {
		return elgg_count_entities($this->getOptions());
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(Result $result, $offset): Result {
		
		$groups = elgg_get_entities($this->getOptions([
			'offset' => $offset,
		]));
		/* @var $group \ElggGroup */
		foreach ($groups as $group) {
			$group->setPluginSetting('poll', 'enable_group_members', $group->getPrivateSetting('poll_enable_group_members'));
			$group->removePrivateSetting('poll_enable_group_members');
			
			$result->addSuccesses();
		}
		
		return $result;
	}
	
	/**
	 * Get options for elgg_get_entities()
	 *
	 * @param array $options additional options
	 *
	 * @return array
	 * @see elgg_get_entities()
	 */
	protected function getOptions(array $options = []): array {
		$defaults = [
			'type' => 'group',
			'limit' => 50,
			'private_settings_names'=> [
				'poll_enable_group_members'
			],
			'batch' => true,
			'batch_inc_offset' => $this->needsIncrementOffset(),
		];
		
		return array_merge($defaults, $options);
	}
}
