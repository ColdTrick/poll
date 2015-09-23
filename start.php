<?php
/**
 * This file is loaded when all the active plugins get loaded
 */

require_once(dirname(__FILE__) . '/lib/functions.php');

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
	
	// group tool option
	if (poll_is_enabled_for_group()) {
		add_group_tool_option('poll', elgg_echo('poll:group_tool:title'), false);
	}
	
	// plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:site', ['\ColdTrick\Poll\MenuHandler', 'siteMenu']);
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', ['\ColdTrick\Poll\MenuHandler', 'userOwnerBlock']);
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', ['\ColdTrick\Poll\MenuHandler', 'groupOwnerBlock']);
	
	// register actions
	elgg_register_action('poll/edit', dirname(__FILE__) . '/actions/poll/edit.php');
}
