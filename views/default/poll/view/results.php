<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof Poll) {
	return;
}

if ($entity->canVote() && !$entity->getVote()) {
	return;
}

// poll results
$votes = $entity->getVotes();
if (empty($votes)) {
	echo elgg_view('page/components/no_results', ['no_results' => elgg_echo('poll:no_votes')]);
	return;
}

elgg_require_js('poll/view/results');

// convert votes result to be used in charts
$results_output = $entity->results_output;
if ($results_output !== 'bar') {
	$results_output = 'pie';
}

$results = [
	'labels' => [],
];
foreach ($votes as $vote) {
	$results['labels'][] = elgg_extract('label', $vote);
	
	$results['datasets'][0]['data'][] = elgg_extract('value', $vote);
	$results['datasets'][0]['backgroundColor'][] = elgg_extract('color', $vote);
}

// chart canvas (default options for pie)
$canvas_options = [
	'id' => 'poll-result-chart',
	'class' => ['poll-result-chart'],
	'data-chart-type' => $results_output,
	'data-chart-data' => json_encode($results),
	'width' => '100%',
	'height' => '200px',
];

if ($results_output === 'bar') {
	$canvas_options['class'][] = 'poll-bar';
	$canvas_options['height'] = '400px';
}

$poll_content = elgg_format_element('canvas', $canvas_options);

// custom legend
$legend = '';
foreach ($votes as $vote) {
	$icon = elgg_format_element('span', [
		'style' => 'background: ' . elgg_extract('color', $vote),
		'class' => 'poll-bar-legend-item',
	]);
	$text = elgg_extract('full_label', $vote);
	$legend .= elgg_format_element('div', [], elgg_view_image_block($icon, $text));
}
$poll_content .= elgg_format_element('div', ['class' => 'poll-bar-legend'], $legend);

echo elgg_format_element('div', ['class' => ['poll-content', 'poll-result-chart-wrapper']], $poll_content);
