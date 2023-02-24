<?php

namespace ColdTrick\Poll\Forms;

/**
 * Prepare form fields for Polls
 */
class PrepareFields {
	
	/**
	 * Add field config for polls
	 *
	 * @param \Elgg\Event $event 'form:prepare:fields', 'poll/edit'
	 *
	 * @return array
	 */
	public function __invoke(\Elgg\Event $event): array {
		$vars = $event->getValue();
		
		$values = [
			'title' => null,
			'description' => null,
			'access_id' => null,
			'tags' => null,
			'guid' => null,
			'answers' => null,
			'container_guid' => elgg_get_page_owner_guid(),
			'comments_allowed' => 'no',
			'close_date' => null,
			'results_output' => 'pie',
		];
		
		// edit of an entity
		$entity = elgg_extract('entity', $vars);
		if ($entity instanceof \Poll) {
			foreach ($values as $name => $default_value) {
				$values[$name] = $entity->$name;
			}
			
			if (!empty($values['answers'])) {
				$values['answers'] = json_decode($values['answers'], true);
			}
		}
		
		return array_merge($values, $vars);
	}
}
