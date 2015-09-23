<?php

$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

$entity = get_entity($guid);
if (!$entity->canEdit()) {
	register_error(elgg_echo(''));
	forward(REFERER);
}

$title = $entity->title;
$container = $entity->getContainerEntity();

if ($entity->delete()) {
	system_message(elgg_echo('entity:delete:success', [$title]));
	
	if ($container instanceof ElggUser) {
		forward("poll/owner/{$container->username}");
	} elseif ($container instanceof ElggGroup) {
		forward("poll/group/{$container->getGUID()}/all");
	}
} else {
	register_error(elgg_echo('entity:delete:fail', [$title]));
}

forward(REFERER);
