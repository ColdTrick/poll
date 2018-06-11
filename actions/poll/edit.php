<?php

elgg_make_sticky_form('poll');

$guid = (int) get_input('guid');
$container_guid = (int) get_input('container_guid');

$title = get_input('title');
$description = get_input('description');
$access_id = (int) get_input('access_id');

$tags = string_to_tag_array(get_input('tags'));
$comments_allowed = get_input('comments_allowed', 'no');
$close_date = get_input('close_date');
$results_output = get_input('results_output');

$answers = (array) get_input('answers', []);

if (empty($guid) && empty($container_guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (empty($title)) {
	return elgg_error_response(elgg_echo('poll:action:edit:error:title'));
}

$new_entity = true;
if (!empty($guid)) {
	elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);
	
	$entity = get_entity($guid);
	if (!$entity->canEdit()) {
		return elgg_error_response(elgg_echo('poll:edit:error:cant_edit'));
	}
	$new_entity = false;
} else {
	$entity = new Poll();
	$entity->container_guid = $container_guid;
	$entity->access_id = $access_id;
	
	if (!$entity->save()) {
		return elgg_error_response(elgg_echo('save:fail'));
	}
}

$entity->title = $title;
$entity->description = $description;
$entity->access_id = $access_id;

$entity->tags = $tags;
$entity->comments_allowed = $comments_allowed;
$entity->results_output = $results_output;

if (empty($close_date)) {
	unset($entity->close_date);
} else {
	$date = getdate($close_date);
	$new_close_date = mktime(23, 59, 59, $date['mon'], $date['mday'], $date['year']);
	$entity->close_date = $new_close_date;
}

foreach ($answers as $index => $answer) {
	$name = elgg_extract('name', $answer);
	$label = elgg_extract('label', $answer);
	
	if ($name === '' || $label === '') {
		unset($answers[$index]);
	}
}
$answers = json_encode(array_values($answers));
$entity->answers = $answers;

if (!$entity->save()) {
	return elgg_error_response(elgg_echo('save:fail'));
}

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

return elgg_ok_response('', elgg_echo('save:success'), $entity->getURL());
