<?php

$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);

$entity = get_entity($guid);
if (!$entity->canEdit()) {
	return elgg_error_response(elgg_echo('poll:edit:error:cant_edit'));
}

$title = $entity->title;
$container = $entity->getContainerEntity();

if (!$entity->delete()) {
	return elgg_error_response(elgg_echo('entity:delete:fail', [$title]));
}

$forward = REFERER;

if ($container instanceof ElggUser) {
	$forward = elgg_generate_url('collection:object:poll:owner', ['username' => $container->username]);
} elseif ($container instanceof ElggGroup) {
	$forward = elgg_generate_url('collection:object:poll:group', ['guid' => $container->guid]);
}

return elgg_ok_response('', elgg_echo('entity:delete:success', [$title]), $forward);
