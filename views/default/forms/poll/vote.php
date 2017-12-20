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
$vote = $entity->getVote(false, 0, $entity->is_multi_answer);
if ($vote !== false) {
    $answer_value = $vote;
}

// title
echo elgg_format_element('h3', ['class' => 'mbs'], elgg_echo('poll:vote:title'));

// voting options
if ($entity->is_multi_answer) {
    $vote = elgg_view('input/checkboxes', [
        'name' => 'vote',
        'options' => $answer_options,
        'value' => $answer_value,
    ]);
} else {
    $vote = elgg_view('input/radio', [
        'name' => 'vote',
        'options' => $answer_options,
        'value' => $answer_value,
    ]);
}
echo elgg_format_element('div', [], $vote);

// footer
$footer = elgg_view('input/hidden', [
    'name' => 'guid',
    'value' => $entity->getGUID(),
        ]);
$footer .= elgg_view('input/submit', [
    'value' => elgg_echo('poll:vote'),
        ]);
echo elgg_format_element('div', ['class' => 'elgg-foot'], $footer);
