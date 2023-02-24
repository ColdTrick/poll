<?php

$guid = (int) get_input('guid');
$vote = get_input('vote');

$entity = get_entity($guid);
if (!$entity instanceof \Poll) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if ($vote === null || $vote === '') {
	return elgg_error_response(elgg_echo('poll:action:vote:error:input'));
}

if (!$entity->canVote()) {
	return elgg_error_response(elgg_echo('poll:action:vote:error:can_vote'));
}

if (!$entity->vote($vote)) {
	return elgg_error_response(elgg_echo('poll:action:vote:error:vote'));
}

return elgg_ok_response('', elgg_echo('poll:action:vote:success'));
