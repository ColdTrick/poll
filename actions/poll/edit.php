<?php

elgg_make_sticky_form('poll');

$guid = (int) get_input('guid');
$container_guid = (int) get_input('container_guid');

$title = get_input('title');
$description = get_input('description');
$access_id = (int) get_input('access_id');

$tags = string_to_tag_array(get_input('tags'));
$comments_allowed = get_input('comments_allowed', 'no');

$answers = (array) get_input('answers', []);

if (empty($guid) && empty($container_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

if (empty($title)) {
	register_error(elgg_echo('poll:action:edit:error:title'));
	forward(REFERER);
}

$new_entity = true;
if (!empty($guid)) {
	elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);
	
	$entity = get_entity($guid);
	if (!$entity->canEdit()) {
		register_error(elgg_echo('poll:edit:error:cant_edit'));
		forward(REFERER);
	}
	$new_entity = false;
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

foreach ($answers as $index => $answer) {
	$name = elgg_extract('name', $answer);
	$label = elgg_extract('label', $answer);
	
	if ($name === '' || $label === '') {
		unset($answers[$index]);
	}
}
$answers = json_encode(array_values($answers));
$entity->answers = $answers;

if ($entity->save()) {
	elgg_clear_sticky_form('poll');
	
	// only add river item for new polls
	if ($new_entity) {
		elgg_create_river_item([
			'view' => 'river/object/poll/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $entity->getGUID(),
			'target_guid' => $entity->getContainerGUID(),
			'access_id' => $entity->access_id,
		]);
	}
	
	system_message(elgg_echo('save:success'));
	forward($entity->getURL());
} else {
	register_error(elgg_echo('save:fail'));
}

forward(REFERER);