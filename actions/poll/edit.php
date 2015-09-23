<?php

elgg_make_sticky_form('poll');

$guid = (int) get_input('guid');
$container_guid = (int) get_input('container_guid');

$title = get_input('title');
$description = get_input('description');
$access_id = (int) get_input('access_id');

$tags = string_to_tag_array(get_input('tags'));
$comments_allowed = get_input('comments_allowed', 'no');

if (empty($guid) && empty($container_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

if (empty($title)) {
	register_error(elgg_echo('poll:action:edit:error:title'));
	forward(REFERER);
}

if (!empty($guid)) {
	elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);
	
	$entity = get_entity($guid);
	if (!$entity->canEdit()) {
		register_error(elgg_echo('poll:edit:error:cant_edit'));
		forward(REFERER);
	}
} else {
	$entity = new Poll();
	$entity->container_guid = $container_guid;
	$entity->access_id = $access_id;
	
	if (!$entity->save()) {
		register_error(elgg_echo('save:fail'));
		forward(REFERER);
	}
}

$entity->title = $title;
$entity->description = $description;
$entity->access_id = $access_id;

$entity->tags = $tags;
$entity->comments_allowed = $comments_allowed;

if ($entity->save()) {
	elgg_clear_sticky_form('poll');
	
	system_message(elgg_echo('save:success'));
	forward($entity->getURL());
} else {
	register_error(elgg_echo('save:fail'));
}

forward(REFERER);