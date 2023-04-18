<?php

namespace ColdTrick\Poll;

use Elgg\Groups\ToolContainerLogicCheck;

/**
 * Prevent polls from being created if the group tool option is disabled
 */
class GroupToolContainerLogicCheck extends ToolContainerLogicCheck {

	/**
	 * {@inheritDoc}
	 */
	public function getContentType(): string {
		return 'object';
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getContentSubtype(): string {
		return \Poll::SUBTYPE;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getToolName(): string {
		return 'poll';
	}
}
