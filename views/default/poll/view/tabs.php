<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \Poll) {
	return;
}

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
$content = elgg_view('poll/view/results', $vars);
if (!empty($content)) {
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

if (count($tabs) > 1) {
	echo elgg_view('page/components/tabs', ['tabs' => $tabs]);
} else {
	echo elgg_extract('content', elgg_extract(0, $tabs));
}
