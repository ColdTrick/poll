<?php

namespace ColdTrick\Poll;

class EditForm {
	
	/**
	 * @var \Poll|null
	 */
	protected $entity;
	
	/**
	 * Create edit form helper
	 *
	 * @param \Poll $entity poll to edit
	 */
	public function __construct(\Poll $entity = null) {
		$this->entity = $entity;
	}
	
	/**
	 * Get the body vars for the edit form
	 *
	 * @return array
	 */
	public function __invoke(): array {
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
		
		// edit form
		if ($this->entity instanceof \Poll) {
			foreach ($values as $key => $value) {
				$values[$key] = $this->entity->$key;
			}
			
			if (!empty($values['answers'])) {
				$values['answers'] = json_decode($values['answers'], true);
			}
			
			$values['entity'] = $this->entity;
		}
		
		// sticky form values
		if (elgg_is_sticky_form('poll')) {
			$sticky_values = elgg_get_sticky_values('poll');
			foreach ($sticky_values as $key => $value) {
				$values[$key] = $value;
			}
			
			elgg_clear_sticky_form('poll');
		}
		
		return $values;
	}
}
