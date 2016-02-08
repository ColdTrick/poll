<?php

class Poll extends \ElggObject {
	
	const SUBTYPE = 'poll';
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::initializeAttributes()
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggEntity::getURL()
	 */
	public function getURL() {
		return "poll/view/{$this->getGUID()}";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::canComment()
	 */
	public function canComment($user_guid = 0) {
		
		if ($this->comments_allowed !== 'yes') {
			return false;
		}
		
		return parent::canComment($user_guid);
	}
	
	/**
	 * Get the stored answers
	 *
	 * @return void|array
	 */
	public function getAnswers() {
		return @json_decode($this->answers, true);
	}
	
	/**
	 * Get the answers in a way to use in input/radios
	 *
	 * @return array
	 */
	public function getAnswersOptions() {
		
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
	 * Get the label assosiated with a answer-name
	 *
	 * @param string $answer the answer name
	 *
	 * @return false|string
	 */
	public function getAnswerLabel($answer) {
		
		$answers = $this->getAnswers();
		if (empty($answers)) {
			return false;
		}
		
		foreach ($answers as $stored_answer) {
			$name = elgg_extract('name' , $stored_answer);
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
	public function canVote($user_guid = 0) {
		
		$user_guid = sanitise_int($user_guid, false);
		if (empty($user_guid)) {
			$user_guid = elgg_get_logged_in_user_guid();
		}
		
		if (empty($user_guid)) {
			return false;
		}
		
		if (!$this->getAnswers()) {
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
	public function vote($answer, $user_guid = 0) {
		
		$user_guid = sanitise_int($user_guid, false);
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
		
		elgg_create_river_item([
			'view' => 'river/object/poll/vote',
			'action_type' => 'vote',
			'subject_guid' => $user_guid,
			'object_guid' => $this->getGUID(),
			'target_guid' => $this->getContainerGUID(),
			'annotation_id' => $annotation_id,
			'access_id' => $this->access_id,
		]);
		
		return true;
	}
	
	/**
	 * Get the vote of a user
	 * @param int $user_guid the user to get the vote for, defaults to current user
	 *
	 * @return false|string|\ElggAnnotation
	 */
	public function getVote($value_only = true, $user_guid = 0) {
		
		$value_only = (bool) $value_only;
		$user_guid = sanitise_int($user_guid, false);
		if (empty($user_guid)) {
			$user_guid = elgg_get_logged_in_user_guid();
		}
		
		if (empty($user_guid)) {
			return false;
		}
		
		$annotations = $this->getAnnotations([
			'annotation_name' => 'vote',
			'annotation_owner_guid' => $user_guid,
			'limit' => 1,
		]);
		if (empty($annotations)) {
			return false;
		}
		
		if ($value_only) {
			return $annotations[0]->value;
		}
		
		return $annotations[0];
	}
	
	/**
	 * Get all the votes in a count array
	 *
	 * @return false|array
	 */
	public function getVotes() {
		
		$answers = $this->getAnswers();
		if (empty($answers)) {
			return [];
		}
		
		$results = [];
		foreach ($answers as $answer) {
			$name = elgg_extract('name', $answer);
			$label = elgg_extract('label', $answer);
			
			$results[$name] = [
				'label' => $label,
				'value' => 0,
				'color' => '#' . substr(md5($name), 0, 6),
			];
		}
		
		$votes = $this->getAnnotations([
			'annotation_name' => 'vote',
			'limit' => false,
		]);
		
		if (empty($votes)) {
			return false;
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
}
