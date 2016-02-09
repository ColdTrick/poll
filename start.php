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
	elgg_define_js('chartjs', [
		'src' => '/mod/poll/vendors/Chart.js/Chart.min.js',
	]);
	
	// css
	elgg_extend_view('css/elgg', 'css/poll/site.css');
	
	// register page handler
	elgg_register_page_handler('poll', ['\ColdTrick\Poll\PageHandlers', 'pollHandler']);
	
	// searchable
	elgg_register_entity_type('object', Poll::SUBTYPE);
	
	// group tool option
	if (poll_is_enabled_for_group()) {
		add_group_tool_option('poll', elgg_echo('poll:group_tool:title'), false);
		elgg_extend_view('groups/tool_latest', 'poll/group_module');
		elgg_extend_view('groups/edit', 'poll/group_settings');
	}
	
	// widgets
	elgg_register_widget_type('recent_polls', elgg_echo('poll:widgets:recent_polls:title'), elgg_echo('poll:widgets:recent_polls:description'), ['index', 'profile', 'dashboard', 'groups']);
	elgg_register_widget_type('single_poll', elgg_echo('poll:widgets:single_poll:title'), elgg_echo('poll:widgets:single_poll:description'), ['index', 'profile', 'groups'], true);
	
	elgg_register_plugin_hook_handler('entity:url', 'object', ['\ColdTrick\Poll\Widgets', 'widgetUrls']);
	elgg_register_plugin_hook_handler('group_tool_widgets', 'widget_manager', ['\ColdTrick\Poll\Widgets', 'groupToolWidgets']);
	
	// notifications
	elgg_register_notification_event('object', Poll::SUBTYPE, ['create']);
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:' . Poll::SUBTYPE, ['\ColdTrick\Poll\Notifications', 'createPoll']);
	
	elgg_register_plugin_hook_handler('entity_types', 'content_subscriptions', '\ColdTrick\Poll\ContentSubscriptions::registerEntityType');
	
	elgg_register_plugin_hook_handler('cron', 'daily', '\ColdTrick\Poll\Notifications::closeCron');
	
	// plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:site', ['\ColdTrick\Poll\MenuHandler', 'siteMenu']);
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', ['\ColdTrick\Poll\MenuHandler', 'userOwnerBlock']);
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', ['\ColdTrick\Poll\MenuHandler', 'groupOwnerBlock']);
	elgg_register_plugin_hook_handler('register', 'menu:poll_tabs', ['\ColdTrick\Poll\MenuHandler', 'pollTabs']);
	elgg_register_plugin_hook_handler('container_permissions_check', 'all', ['\ColdTrick\Poll\Permissions', 'canWriteContainer']);
	
	// register actions
	elgg_register_action('poll/edit', dirname(__FILE__) . '/actions/poll/edit.php');
	elgg_register_action('poll/delete', dirname(__FILE__) . '/actions/poll/delete.php');
	elgg_register_action('poll/vote', dirname(__FILE__) . '/actions/answer/vote.php');
	elgg_register_action('poll/group_settings', dirname(__FILE__) . '/actions/group_settings.php');
}
