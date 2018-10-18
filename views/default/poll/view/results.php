<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Poll)) {
	return;
}

if ($entity->canVote() && !$entity->getVote()) {
	return;
}

elgg_require_js('poll/results');
if (elgg_is_xhr()) {
	echo elgg_format_element('script', [], 'require(["poll/results"], function(){elgg.poll.results.init();});');
}

// poll results
$votes = $entity->getVotes();

// convert votes result to be used in charts
$results_output = $entity->results_output;
if ($results_output !== 'bar') {
	$results_output = 'pie';
}

$results = [
	'labels' => [],
];
$dataset_values = [];
foreach ($votes as $vote) {
	$results['labels'][] = elgg_extract('label', $vote);
	
	$results['datasets'][0]['data'][] = elgg_extract('value', $vote);
	$results['datasets'][0]['backgroundColor'][] = elgg_extract('color', $vote);
}

// chart canvas (default options for pie)
$container_options = [
	'width' => '500px',
	'height' => '200px',
];

$canvas_options = [
	'id' => 'poll-result-chart',
	'class' => ['poll-result-chart'],
	'data-chart-type' => $results_output,
	'data-chart-data' => json_encode($results),
];

if ($results_output === 'bar') {
	$canvas_options['class'][] = 'poll-bar';
	$container_options['width'] = '600px';
	$container_options['height'] = '400px';
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

echo elgg_format_element('div', ['id' => 'poll-result-chart-wrapper', 'class' => 'poll-content'], $poll_content);
