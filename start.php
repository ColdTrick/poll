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
	
	// register js
	elgg_define_js('chart.js', [
		'src' => '/mod/poll/vendors/Chart.js/Chart.min.js',
	]);
	
	// register page handler
	elgg_register_page_handler('poll', ['\ColdTrick\Poll\PageHandlers', 'pollHandler']);
	
	// group tool option
	if (poll_is_enabled_for_group()) {
		add_group_tool_option('poll', elgg_echo('poll:group_tool:title'), false);
	}
	
	// notifications
	elgg_register_notification_event('object', Poll::SUBTYPE, ['create']);
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:' . Poll::SUBTYPE, ['\ColdTrick\Poll\Notifications', 'createPoll']);
	
	// plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:site', ['\ColdTrick\Poll\MenuHandler', 'siteMenu']);
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', ['\ColdTrick\Poll\MenuHandler', 'userOwnerBlock']);
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', ['\ColdTrick\Poll\MenuHandler', 'groupOwnerBlock']);
	
	// register actions
	elgg_register_action('poll/edit', dirname(__FILE__) . '/actions/poll/edit.php');
	elgg_register_action('poll/delete', dirname(__FILE__) . '/actions/poll/delete.php');
}
