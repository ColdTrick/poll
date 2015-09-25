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
		
		// check if user voted already
		
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
		
		return (bool) $this->annotate('vote', $answer, $this->access_id, $user_guid);
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
			'owner_guid' => $user_guid,
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
}
