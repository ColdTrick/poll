<?php

/**
 * Poll entity class
 *
 * @property string $answers          JSON encoded answer configuration
 * @property int    $close_date       timestamp when the voting for the poll will be closed
 * @property string $comments_allowed are comments allowed
 * @property string $results_output   how to display the poll results
 */
class Poll extends \ElggObject {
	
	const SUBTYPE = 'poll';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canComment($user_guid = 0): bool {
		if ($this->comments_allowed !== 'yes') {
			return false;
		}
		
		return parent::canComment($user_guid);
	}
	
	/**
	 * Get the stored answers
	 *
	 * @return null|array
	 */
	public function getAnswers(): ?array {
		return @json_decode($this->answers, true);
	}
	
	/**
	 * Get the answers in a way to use in input/radios
	 *
	 * @return array
	 */
	public function getAnswersOptions(): array {
		$answers = $this->getAnswers();
		if (empty($answers)) {
			return [];
		}
		
		$result = [];
		foreach ($answers as $answer) {
			$name = elgg_extract('name', $answer);
			$label = elgg_extract('label', $answer);
			
			$result[$label] = $name;
		}
		
		return $result;
	}
	
	/**
	 * Get the label associated with an answer-name
	 *
	 * @param string $answer the answer name
	 *
	 * @return string
	 */
	public function getAnswerLabel(string $answer): string {
		$answers = $this->getAnswers();
		if (empty($answers)) {
			return '';
		}
		
		foreach ($answers as $stored_answer) {
			$name = elgg_extract('name', $stored_answer);
			if ($name !== $answer) {
				continue;
			}
			
			return elgg_extract('label', $stored_answer);
		}
		
		return false;
	}
	
	/**
	 * Check if a user can vote for this poll
	 *
	 * @param int $user_guid (optional) user_guid to check, defaults to current user
	 *
	 * @return bool
	 */
	public function canVote(int $user_guid = 0): bool {
		if (empty($user_guid)) {
			$user_guid = elgg_get_logged_in_user_guid();
		}
		
		if (empty($user_guid)) {
			return false;
		}
		
		if (!$this->getAnswers()) {
			return false;
		}
		
		if ($this->getVote() && (elgg_get_plugin_setting('vote_change_allowed', 'poll') !== 'yes')) {
			return false;
		}
		
		// check close date
		if ($this->close_date) {
			$close_date = (int) $this->close_date;
			if ($close_date < time()) {
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Register a vote for a user
	 *
	 * @param string $answer    the answer
	 * @param int    $user_guid (optional) the user who is voting, defaults to current user
	 *
	 * @return bool
	 */
	public function vote(string $answer, int $user_guid = 0): bool {
		if (empty($user_guid)) {
			$user_guid = elgg_get_logged_in_user_guid();
		}
		
		if (empty($user_guid)) {
			return false;
		}
		
		$answer_options = $this->getAnswersOptions();
		if (!in_array($answer, $answer_options)) {
			return false;
		}
		
		$existing_vote = $this->getVote(false, $user_guid);
		if (!empty($existing_vote)) {
			$existing_vote->value = $answer;
			return (bool) $existing_vote->save();
		}
		
		$annotation_id = $this->annotate('vote', $answer, $this->access_id, $user_guid);
		if (empty($annotation_id)) {
			return false;
		}
		
		if (elgg_get_plugin_setting('add_vote_to_river', 'poll') === 'yes') {
			elgg_create_river_item([
				'view' => 'river/object/poll/vote',
				'action_type' => 'vote',
				'subject_guid' => $user_guid,
				'object_guid' => $this->guid,
				'target_guid' => $this->container_guid,
				'annotation_id' => $annotation_id,
				'access_id' => $this->access_id,
			]);
		}
		
		return true;
	}
	
	/**
	 * Get the vote of a user
	 *
	 * @param bool $value_only only return the value of the vote
	 * @param int  $user_guid  the user to get the vote for, defaults to current user
	 *
	 * @return null|string|\ElggAnnotation
	 */
	public function getVote(bool $value_only = true, int $user_guid = 0) {
		if (empty($user_guid)) {
			$user_guid = elgg_get_logged_in_user_guid();
		}
		
		if (empty($user_guid)) {
			return null;
		}
		
		$annotations = $this->getAnnotations([
			'annotation_name' => 'vote',
			'annotation_owner_guid' => $user_guid,
			'limit' => 1,
		]);
		if (empty($annotations)) {
			return null;
		}
		
		if ($value_only) {
			return $annotations[0]->value;
		}
		
		return $annotations[0];
	}
	
	/**
	 * Get all the votes in a count array
	 *
	 * @return array
	 */
	public function getVotes(): array {
		$answers = $this->getAnswers();
		if (empty($answers)) {
			return [];
		}
		
		$results = [];
		foreach ($answers as $answer) {
			$name = elgg_extract('name', $answer);
			$label = elgg_extract('label', $answer);
			$short_label = elgg_get_excerpt((string) $label, 20);
			
			$results[$name] = [
				'label' => $short_label,
				'full_label' => $label,
				'value' => 0,
				'color' => '#' . substr(md5($name), 0, 6),
			];
		}
		
		$votes = $this->getAnnotations([
			'annotation_name' => 'vote',
			'limit' => false,
		]);
		
		if (empty($votes)) {
			return [];
		}
		
		foreach ($votes as $vote) {
			$name = $vote->value;
			if (!isset($results[$name])) {
				// no longer an option
				continue;
			}
			
			$results[$name]['value']++;
		}
		
		return array_values($results);
	}
	
	/**
	 * Removes all votes and related river activity
	 *
	 * @return void
	 */
	public function clearVotes(): void {
		$this->deleteAnnotations('vote');
		
		elgg_delete_river([
			'object_guid' => $this->guid,
			'action_type' => 'vote',
			'limit' => false,
		]);
	}
	
	/**
	 * Is the poll closed for voting
	 *
	 * @return bool
	 */
	public function isClosed(): bool {
		$close_date = $this->close_date;
		if (!isset($close_date)) {
			// no close date
			return false;
		}
		
		$close_date = (int) $close_date;
		if ($close_date > time()) {
			// in the future
			return false;
		}
		
		return true;
	}
}
