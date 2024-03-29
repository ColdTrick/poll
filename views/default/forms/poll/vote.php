<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \Poll) {
	return;
}

$answer_options = $entity->getAnswersOptions();
if (empty($answer_options)) {
	return;
}

// voting options
echo elgg_view_field([
	'#type' => 'radio',
	'#label' => elgg_echo('poll:vote:title'),
	'name' => 'vote',
	'options' => $answer_options,
	'value' => $entity->getVote(),
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $entity->guid,
]);

// form footer
$footer = elgg_view_field([
	'#type' => 'submit',
	'text' => elgg_echo('poll:vote'),
]);

elgg_set_form_footer($footer);
