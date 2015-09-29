<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Poll)) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars, false);

$subtitle = [];

$owner = $entity->getOwnerEntity();
$container = $entity->getContainerEntity();

// owner related
$owner_icon = elgg_view_entity_icon($owner, 'small');
$owner_link = elgg_view('output/url', [
	'text' => $owner->name,
	'href' => "poll/owner/{$owner->username}",
	'is_trusted' => true,
]);
$subtitle[] = elgg_echo('byline', [$owner_link]);

// container
if (($container instanceof ElggGroup) && (elgg_get_page_owner_guid() !== $container->getGUID())) {
	$container_link = elgg_view('output/url', [
		'text' => $container->name,
		'href' => "poll/group/{$container->getGUID()}/all",
		'is_trusted' => true,
	]);
	
	$subtitle[] = elgg_echo('river:ingroup', [$container_link]);
}

// date
$subtitle[] = elgg_view_friendly_time($entity->time_created);

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
if (!elgg_in_context('widgets')) {
	$entity_menu = elgg_view_menu('entity',[
		'entity' => $entity,
		'handler' => 'poll',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

if ($full_view) {
	
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
	$body .= elgg_view('poll/view/results', [
		'entity' => $entity,
	]);
	
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
		'content' => elgg_get_excerpt($entity->description),
	];
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($owner_icon, $list_body);
}
