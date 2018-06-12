<?php

// verify input
$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

$entity = get_entity($guid);

// breadcrumb
elgg_push_breadcrumb(elgg_echo('poll:menu:site'), 'poll/all');

$container = $entity->getContainerEntity();
if ($container instanceof ElggUser) {
	elgg_push_breadcrumb($container->name, "poll/owner/{$container->username}");
} elseif ($container instanceof ElggGroup) {
	elgg_push_breadcrumb($container->name, "poll/group/{$container->getGUID()}/all");
}
elgg_push_breadcrumb($entity->title);

// build page elements
$title = $entity->getDisplayName();

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title,
	'content' => elgg_view_entity($entity),
]);

// draw page
echo elgg_view_page($title, $page_data);
