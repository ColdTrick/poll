<?php

// verify input
$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

$entity = get_entity($guid);

// breadcrumb
$container = $entity->getContainerEntity();
if ($container instanceof ElggUser) {
	elgg_push_breadcrumb($container->name, "poll/owner/{$container->username}");
} elseif ($container instanceof ElggGroup) {
	elgg_push_breadcrumb($container->name, "poll/group/{$container->getGUID()}/all");
}
elgg_push_breadcrumb($entity->title);

// build page elements
$title = $entity->title;

$content = elgg_view_entity($entity);

if ($entity->canComment()) {
	$content .= elgg_format_element('h3', ['class' => 'mtm'], elgg_echo('comments'));
	$content .= elgg_view_comments($entity);
}

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title, $page_data);
