<?php

use ColdTrick\Poll\Bootstrap;
use ColdTrick\Poll\Middleware\ContainerGatekeeper;

require_once(dirname(__FILE__) . '/lib/functions.php');

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'plugin' => [
		'version' => '12.1',
	],
	'bootstrap' => Bootstrap::class,
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'poll',
			'class' => 'Poll',
			'capabilities' => [
				'commentable' => true,
				'searchable' => true,
				'likable' => true,
				'restorable' => true,
				'subscribable' => true,
			],
		],
	],
	'settings' => [
		'enable_site' => 'no',
		'enable_group' => 'no',
		'group_create' => 'members',
		'close_date_required' => 'no',
		'vote_change_allowed' => 'yes',
		'add_vote_to_river' => 'yes',
	],
	'actions' => [
		'poll/clear_votes' => [],
		'poll/edit' => [],
		'poll/export' => [],
		'poll/vote' => [],
	],
	'routes' => [
		'collection:object:poll:all' => [
			'path' => '/poll/all',
			'resource' => 'poll/all',
		],
		'collection:object:poll:owner' => [
			'path' => '/poll/owner/{username}',
			'resource' => 'poll/owner',
			'middleware' => [
				\Elgg\Router\Middleware\UserPageOwnerGatekeeper::class,
			],
		],
		'collection:object:poll:group' => [
			'path' => '/poll/group/{guid}/{subpage?}',
			'resource' => 'poll/group',
			'defaults' => [
				'subpage' => 'all',
			],
			'required_plugins' => [
				'groups',
			],
			'middleware' => [
				\Elgg\Router\Middleware\GroupPageOwnerGatekeeper::class,
			],
		],
		'collection:object:poll:friends' => [
			'path' => '/poll/friends/{username}',
			'resource' => 'poll/friends',
			'required_plugins' => [
				'friends',
			],
			'middleware' => [
				\Elgg\Router\Middleware\UserPageOwnerGatekeeper::class,
			],
		],
		'view:object:poll' => [
			'path' => '/poll/view/{guid}/{title?}',
			'resource' => 'poll/view',
		],
		'add:object:poll' => [
			'path' => '/poll/add/{guid}',
			'resource' => 'poll/add',
			'middleware' => [
				ContainerGatekeeper::class,
			],
		],
		'edit:object:poll' => [
			'path' => '/poll/edit/{guid}',
			'resource' => 'poll/edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'default:object:poll' => [
			'path' => '/poll',
			'resource' => 'poll/all',
		],
	],
	'events' => [
		'container_logic_check' => [
			'object' => [
				\ColdTrick\Poll\GroupToolContainerLogicCheck::class => [],
				'\ColdTrick\Poll\Permissions::enabledForSite' => [],
			],
		],
		'container_permissions_check' => [
			'all' => [
				'\ColdTrick\Poll\Permissions::canWriteContainer' => [],
			],
		],
		'cron' => [
			'daily' => [
				'\ColdTrick\Poll\Cron::sendCloseNotifications' => [],
			],
		],
		'entity:url' => [
			'object' => [
				'\ColdTrick\Poll\Widgets::widgetUrls' => [],
			],
		],
		'form:prepare:fields' => [
			'poll/edit' => [
				\ColdTrick\Poll\Forms\PrepareFields::class => [],
			],
		],
		'group_tool_widgets' => [
			'widget_manager' => [
				'\ColdTrick\Poll\Plugins\WidgetManager::groupToolWidgets' => [],
			],
		],
		'register' => [
			'menu:entity' => [
				'\ColdTrick\Poll\Menus\Entity::register' => [],
			],
			'menu:owner_block' => [
				'\ColdTrick\Poll\Menus\OwnerBlock::registerGroup' => [],
				'\ColdTrick\Poll\Menus\OwnerBlock::registerUser' => [],
			],
			'menu:site' => [
				'\ColdTrick\Poll\Menus\Site::register' => [],
			],
		],
		'seeds' => [
			'database' => [
				'\ColdTrick\Poll\Seeder::register' => [],
			],
		],
		'supported_types' => [
			'entity_tools' => [
				'\ColdTrick\Poll\Plugins\EntityTools::registerPoll' => [],
			],
		],
		'tool_options' => [
			'group' => [
				'\ColdTrick\Poll\Plugins\Groups::registerTool' => [],
			],
		],
	],
	'notifications' => [
		'object' => [
			'poll' => [
				'close' => \ColdTrick\Poll\Notifications\ClosePollHandler::class,
				'create' => \ColdTrick\Poll\Notifications\CreatePollHandler::class,
			],
		],
	],
	'views' => [
		'default' => [
			'chart.js/' => $composer_path . 'vendor/npm-asset/chart.js/dist/',
		],
	],
	'view_extensions' => [
		'elgg.css' => [
			'poll/site.css' => [],
		],
		'groups/edit/settings' => [
			'poll/group_settings' => [],
		],
	],
	'widgets' => [
		'recent_polls' => [
			'context' => ['profile', 'dashboard', 'groups', 'index'],
		],
		'single_poll' => [
			'context' => ['profile', 'groups', 'index'],
			'multiple' => true,
		],
	],
];
