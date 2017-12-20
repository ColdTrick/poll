<?php

$guid = (int) get_input('guid');
$vote = get_input('vote');
// if one vote, put it in array for processing
if (!is_array($vote)) {
    $vote = array($vote);
}
elgg_entity_gatekeeper($guid, 'object', Poll::SUBTYPE);
$entity = get_entity($guid);

if ($vote === null || $vote === '') {
    register_error(elgg_echo('poll:action:vote:error:input'));
    forward(REFERER);
}

if (!$entity->canVote()) {
    register_error(elgg_echo('poll:action:vote:error:can_vote'));
    forward(REFERER);
}


if ($entity->vote($vote)) {
    system_message(elgg_echo('poll:action:vote:success'));
} else {
    register_error(elgg_echo('poll:action:vote:error:vote'));
}


forward(REFERER);
