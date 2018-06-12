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
	$tabs = [];
	
	// add answers form
	if ($entity->canVote()) {
		
		$form_vars = [
			'class' => 'mvm poll-content',
			'id' => 'poll-vote-form',
		];
		
		$content = elgg_view_form('poll/vote', $form_vars, ['entity' => $entity]);

		$tabs[] = [
			'name' => 'vote_form',
			'text' => elgg_echo('poll:menu:poll_tabs:vote'),
			'href' => false,
			'selected' => (bool) !$entity->getVote(),
			'content' => $content,
		];
	}
	
	// show results
	if ($entity->getVotes()) {
		$content = elgg_view('poll/view/results', $vars);
		
		$selected = !$entity->canVote() || (bool) $entity->getVote();
		
		$tabs[] = [
			'name' => 'results',
			'text' => elgg_echo('poll:menu:poll_tabs:results'),
			'href' => false,
			'selected' => $selected,
			'data-is-chart' => true,
			'content' => $content,
		];
	}
	
	$body .= elgg_view('page/components/tabs', ['tabs' => $tabs]);
	
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
