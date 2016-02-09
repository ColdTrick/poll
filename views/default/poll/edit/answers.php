<?php

$answers = (array) elgg_extract('answers', $vars);
$answers[] = []; // add a blank option

// reset keys
$answers = array_values($answers);

$answers_list = '';

foreach ($answers as $index => $answer) {
	
	$name = elgg_extract('name', $answer);
	$label = elgg_extract('label', $answer);
	
	if ($name === '' && $label === '') {
		continue;
	}
	
	$answer_fields = '';
	
	$answer_fields .= '<table class="elgg-discover"><tr><td class="poll-edit-answers-icon">';
	
	$answer_fields .= elgg_view_icon('drag-arrow', ['class' => 'elgg-discoverable']);

	$answer_fields .= '</td><td>';

	$answer_fields .= elgg_view('input/text', [
		'name' => "answers[$index][label]",
		'placeholder' => elgg_echo('poll:edit:answers:label'),
		'value' => $label,
	]);
	

	$answer_fields .= '</td><td class="poll-edit-answers-name hidden pls">';
	
	$answer_fields .= elgg_view('input/text', [
		'name' => "answers[$index][name]",
		'placeholder' => elgg_echo('poll:edit:answers:name'),
		'value' => $name,
	]);
	
	$answer_fields .= '</td><td class="poll-edit-answers-icon">';
	$answer_fields .= elgg_view_icon('settings-alt', [
		'class' => 'elgg-discoverable',
		'rel' => 'toggle',
		'data-toggle-selector' => '.poll-edit-answers-name',
		'title' => elgg_echo('poll:edit:answers:show_internal_names'),
	]);
	$answer_fields .= elgg_view_icon('delete', ['class' => 'elgg-discoverable']);
	
	$answer_fields .= '</td></tr></table>';
	
	$li_options = ['data-index' => $index];
	if ($index == (count($answers) - 1)) {
		$li_options['class'] = 'poll-edit-answers-blank';
	}
	$answers_list .= elgg_format_element('li', $li_options, $answer_fields);
}

echo elgg_format_element('ul', ['class' => 'poll-edit-answers'], $answers_list);
