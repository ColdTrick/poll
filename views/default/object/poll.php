<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Poll)) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars, false);
$show_entity_menu = (bool) elgg_extract('show_entity_menu', $vars, !elgg_in_context('widgets'));

$owner = $entity->getOwnerEntity();

// owner related
$owner_icon = elgg_view_entity_icon($owner, 'small');

// create subtitle
$subtitle = [];

$vars['owner_url'] = "poll/owner/{$owner->username}";
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

// entity menu
$entity_menu = '';
if ($show_entity_menu) {
	$entity_menu = elgg_view_menu('entity',[
		'entity' => $entity,
		'handler' => 'poll',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

if (elgg_in_context('widgets') && $full_view) {
	// single poll in widget
	
	// summary
	$params = [
		'entity' => $entity,
		'metadata' => $entity_menu,
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
	
} elseif ($full_view) {
	
	// summary
	$params = [
		'entity' => $entity,
		'title' => false,
		'metadata' => $entity_menu,
		'subtitle' => implode(' ', $subtitle),
	];
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	
	// body
	$body = elgg_view('output/longtext', [
		'value' => $entity->description,
	]);
	
	// tabbed
	$body .= elgg_view_menu('poll_tabs', [
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
	
	// make full view
	echo elgg_view('object/elements/full', [
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $body,
	]);
	
} else {
	$params = [
		'entity' => $entity,
		'metadata' => $entity_menu,
		'subtitle' => implode(' ', $subtitle),
		'content' => elgg_get_excerpt($entity->description) . elgg_view('poll/view/close_date', $vars),
	];
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($owner_icon, $list_body);
}
