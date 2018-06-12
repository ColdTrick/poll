<?php
/**
 * View for poll objects
 *
 * @uses $vars['entity'] Poll entity to show
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \Poll) {
	return;
}

if (elgg_extract('full_view', $vars)) {
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

	$params = [
		'icon' => true,
		'body' => $body,
		'show_summary' => true,
		'show_navigation' => true,
	];
	$params = $params + $vars;
	
	echo elgg_view('object/elements/full', $params);
} else {
	$content = elgg_get_excerpt($entity->description) . elgg_view('poll/view/close_date', $vars);
	
	// brief view
	$params = [
		'content' => $content,
		'icon' => true,
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
}
