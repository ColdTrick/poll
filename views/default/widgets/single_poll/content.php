<?php

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);

$poll_guid = $widget->poll_guid;
if (is_array($poll_guid)) {
	$poll_guid = $poll_guid[0];
}

$entity = get_entity($poll_guid);
if (!$entity instanceof Poll) {
	echo elgg_echo('poll:widgets:single_poll:misconfigured');
	return;
}

// summary
$params = [
	'entity' => $entity,
	'content' => elgg_get_excerpt($entity->description),
	'tags' => false,
	'icon' => false,
];
$params = $params + $vars;
echo elgg_view('object/elements/summary', $params);
	
// tabbed
$body = elgg_view_menu('poll_tabs', [
	'entity' => $entity,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz elgg-tabs mtm',
]);

// add answers form
if ($entity->canVote()) {
	$form_vars = [
		'class' => 'mvm poll-content',
		'id' => 'poll-vote-form',
	];
	if ($entity->getVote()) {
		$form_vars['class'] .= ' hidden';
	}
	
	$body .= elgg_view_form('poll/vote', $form_vars, ['entity' => $entity]);
}

// show results
if ($entity->getVotes()) {
	$body .= elgg_view('poll/view/results', [
		'entity' => $entity,
	]);
}

$body .= elgg_view('poll/view/close_date', $vars);

echo $body;
