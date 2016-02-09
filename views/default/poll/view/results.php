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
$results = $entity->getVotes();

// chart canvas (default options for pie)
$canvas_options = [
	'width' => '500px',
	'height' => '200px',
	'id' => 'poll-result-chart',
	'class' => 'poll-result-chart',
	'data-chart-type' => 'pie',
];

$results_output = $entity->results_output;
if ($results_output !== 'bar') {
	$results_output = 'pie';
}

if ($results_output === 'pie') {
	$canvas_options['data-chart-data'] = json_encode($results);

} else {
	// convert to bar data array
	$bar_data = [
		'labels' => [],
	];
	$values = [];
	foreach ($results as $result) {
		$bar_data['labels'][] = elgg_extract('label', $result);
		$values[] = elgg_extract('value', $result);
	}
	$bar_data['datasets'][] = [
		'data' => $values,
		'fillColor' => 'rgba(96, 184, 247, 0.5)',
		'strokeColor' => 'rgba(71, 135, 184, 0.8)',
		'highlightFill' => 'rgba(96, 184, 247, 0.75)',
		'highlightStroke' => 'rgba(71, 135, 184, 1)',
	];
	
	$canvas_options['width'] = '600px';
	$canvas_options['data-chart-type'] = 'bar';
	$canvas_options['data-chart-data'] = json_encode($bar_data);
}

echo elgg_format_element('div', ['id' => 'poll-result-chart-wrapper', 'class' => 'poll-content'], elgg_format_element('canvas', $canvas_options));
