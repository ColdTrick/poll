<?php

namespace ColdTrick\Poll\Controllers;

use Elgg\Database\Select;

/**
 * Export votes
 *
 * @since 7.0
 */
class Export extends \Elgg\Controllers\CsvDownloadAction {

	protected \Poll $entity;

	/**
	 * {@inheritdoc}
	 */
	protected function validate(): void	{
		$this->entity = elgg_entity_gatekeeper((int) get_input('guid'), 'object', \Poll::SUBTYPE, true);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getFilename(): string {
		return 'poll-results-' . elgg_get_friendly_title($this->entity->getDisplayName()) . '-' .  date('Y-m-d-Hi') . '.csv';
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getContentHeaders(): array {
		return [
			elgg_echo('poll:edit:answers'),
			elgg_echo('total'),
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getContentRows(): array {
		$votes = $this->entity->getVotes();
		
		$results = [];
		foreach ($votes as $vote) {
			$results[] = [
				elgg_extract('full_label', $vote),
				elgg_extract('value', $vote),
			];
		}
		
		return $results;
	}
}
