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
}
