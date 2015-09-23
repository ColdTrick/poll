<?php
/**
 * This file is loaded when all the active plugins get loaded
 */

// register default Elgg events
elgg_register_event_handler('init', 'system', 'poll_init');

/**
 * Called during system init
 *
 * @return void
 */
function poll_init() {
	
	// register page handler
	elgg_register_page_handler('poll', ['\ColdTrick\Poll\PageHandlers', 'pollHandler']);
	
	// register actions
	elgg_register_action('poll/edit', dirname(__FILE__) . '/actions/poll/edit.php');
}
