<?php

namespace ColdTrick\Poll;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 */
	public function init() {
		
		// css
		elgg_extend_view('css/elgg', 'css/poll/site.css');
						
		// group tool option
		if (poll_is_enabled_for_group()) {
			add_group_tool_option('poll', elgg_echo('poll:group_tool:title'), false);
			elgg_extend_view('groups/tool_latest', 'poll/group_module');
			elgg_extend_view('groups/edit', 'poll/group_settings');
		}
		
		elgg_register_notification_event('object', 'poll', ['create']);
		
		elgg_register_plugin_hook_handler('entity:url', 'object', ['\ColdTrick\Poll\Widgets', 'widgetUrls']);
		elgg_register_plugin_hook_handler('group_tool_widgets', 'widget_manager', ['\ColdTrick\Poll\Widgets', 'groupToolWidgets']);
		elgg_register_plugin_hook_handler('prepare', 'notification:create:object:poll', ['\ColdTrick\Poll\Notifications', 'createPoll']);
		elgg_register_plugin_hook_handler('entity_types', 'content_subscriptions', '\ColdTrick\Poll\ContentSubscriptions::registerEntityType');
		elgg_register_plugin_hook_handler('cron', 'daily', '\ColdTrick\Poll\Notifications::closeCron');
		elgg_register_plugin_hook_handler('register', 'menu:site', ['\ColdTrick\Poll\MenuHandler', 'siteMenu']);
		elgg_register_plugin_hook_handler('register', 'menu:owner_block', ['\ColdTrick\Poll\MenuHandler', 'userOwnerBlock']);
		elgg_register_plugin_hook_handler('register', 'menu:owner_block', ['\ColdTrick\Poll\MenuHandler', 'groupOwnerBlock']);
		elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\Poll\MenuHandler::entityMenu');
		elgg_register_plugin_hook_handler('container_permissions_check', 'all', ['\ColdTrick\Poll\Permissions', 'canWriteContainer']);
		elgg_register_plugin_hook_handler('likes:is_likable', 'object:poll', '\Elgg\Values::getTrue');
		elgg_register_plugin_hook_handler('supported_types', 'entity_tools', '\ColdTrick\Poll\MigratePoll::supportedSubtypes');
	}
}
