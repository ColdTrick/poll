<?php

$guid = (int) get_input('guid');
$vote = get_input('vote');

elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);
$entity = get_entity($guid);

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
