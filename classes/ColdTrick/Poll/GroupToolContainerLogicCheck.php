<?php

namespace ColdTrick\Poll;

use Elgg\Groups\ToolContainerLogicCheck;

/**
 * Prevent polls from being created if the group tool option is disabled
 */
class GroupToolContainerLogicCheck extends ToolContainerLogicCheck {

	/**
	 * {@inheritdoc}
	 */
	public function getContentType(): string {
		return 'object';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getContentSubtype(): string {
		return \Poll::SUBTYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getToolName(): string {
		return 'poll';
	}
}
