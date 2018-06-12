<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

use ColdTrick\Poll\Bootstrap;

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
			'path' => '/poll/group/{guid}',
			'resource' => 'poll/group',
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
			'path' => '/poll/add/{guid?}',
			'resource' => 'poll/add',
			'middleware' => [
				\ColdTrick\Poll\Middleware\ContainerGatekeeper::class,
			],
		],
		'edit:object:poll' => [
			'path' => '/poll/edit/{guid}',
			'resource' => 'poll/edit',
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
			'title' => elgg_echo('poll:widgets:recent_polls:title'),
			'description' => elgg_echo('poll:widgets:recent_polls:description'),
			'context' => ['profile', 'dashboard', 'groups', 'index'],
		],
		'single_poll' => [
			'title' => elgg_echo('poll:widgets:single_poll:title'),
			'description' => elgg_echo('poll:widgets:single_poll:description'),
			'context' => ['profile', 'groups', 'index'],
			'multiple' => true,
		],
	],
];
		