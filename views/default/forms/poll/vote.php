<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Poll)) {
	return;
}

$answer_options = $entity->getAnswersOptions();
if (empty($answer_options)) {
	return;
}

// in case the user already voted
$answer_value = null;
$vote = $entity->getVote();
if ($vote !== false) {
	$answer_value = $vote;
}

// voting options
echo elgg_view_field([
	'#type' => 'radio',
	'#label' => elgg_echo('poll:vote:title'),
	'name' => 'vote',
	'options' => $answer_options,
	'value' => $answer_value,
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $entity->guid,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('poll:vote'),
]);

elgg_set_form_footer($footer);
