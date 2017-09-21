<?php

$widget = elgg_extract('entity', $vars);

$poll_guid = $widget->poll_guid;
if (is_array($poll_guid)) {
	$poll_guid = $poll_guid[0];
}
$poll_guid = sanitise_int($poll_guid);

$entity = get_entity($poll_guid);

if (!($entity instanceof Poll)) {
	echo elgg_echo('poll:widgets:single_poll:misconfigured');
	return;
}

// create subtitle
$subtitle = [];

$vars['owner_url'] = "poll/owner/{$entity->getOwnerEntity()->username}";
$subtitle[] = elgg_view('page/elements/by_line', $vars);

// comments
if ($entity->comments_allowed === 'yes') {
	$comment_count = $entity->countComments();
	if (!empty($comment_count)) {
		$subtitle[] = elgg_view('output/url', [
			'text' => elgg_echo('comments') . " ({$comment_count})",
			'href' => "{$entity->getURL()}#comments",
			'is_trusted' => true,
		]);
	}
}
	
// summary
$params = [
	'entity' => $entity,
	'subtitle' => implode(' ', $subtitle),
	'content' => elgg_get_excerpt($entity->description),
	'tags' => false,
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
	