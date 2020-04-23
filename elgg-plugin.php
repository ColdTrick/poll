<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

use ColdTrick\Poll\Bootstrap;
use ColdTrick\Poll\Middleware\ContainerGatekeeper;
use Elgg\Router\Middleware\Gatekeeper;

return [
	'bootstrap' => Bootstrap::class,
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'poll',
			'class' => 'Poll',
			'searchable' => true,
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
	'routes' => [
		'collection:object:poll:all' => [
			'path' => '/poll/all',
			'resource' => 'poll/all',
		],
		'collection:object:poll:owner' => [
			'path' => '/poll/owner/{username}',
			'resource' => 'poll/owner',
		],
		'collection:object:poll:group' => [
			'path' => '/poll/group/{guid}/{subpage?}',
			'resource' => 'poll/group',
			'defaults' => [
				'subpage' => 'all',
			],
		],
		'collection:object:poll:friends' => [
			'path' => '/poll/friends/{username}',
			'resource' => 'poll/friends',
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
				Gatekeeper::class,
			],
		],
		'default:object:poll' => [
			'path' => '/poll',
			'resource' => 'poll/all',
		],
	],
	'actions' => [
		'poll/edit' => [],
		'poll/export' => [],
		'poll/vote' => [],
		'poll/group_settings' => [],
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
	'views' => [
		'default' => [
			'chartjs.js' => $composer_path . 'vendor/npm-asset/chart.js/dist/Chart.min.js',
		],
	],
];
