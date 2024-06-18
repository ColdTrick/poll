<?php

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (!$entity instanceof \Poll) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (!$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$entity->clearVotes();

return elgg_ok_response('', elgg_echo('poll:action:clear_votes:success'));
