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
if ($entity->canComment()) {
	$comment_count = $entity->countComments();
	if (!empty($comment_count)) {
		$subtitle[] = elgg_view('output/url', [
			'text' => elgg_echo('comments') . "({$comment_count})",
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
	echo $entity->title;
	
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
