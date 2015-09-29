<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Poll)) {
	return;
}

elgg_require_js('poll/results');
if (elgg_is_xhr()) {
	echo elgg_format_element('script', [], 'require(["poll/results"], function(){elgg.poll.results.init();});');
}

// poll results
$results = $entity->getVotes();

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

// chart canvas
$chart_class = [
	'poll-result-chart',
];
$pie_class = ['poll-content'];
if ($entity->canVote() && !$entity->getVote()) {
	$pie_class[] = 'hidden';
}

$pie_chart = elgg_format_element('canvas', [
	'width' => '500px',
	'height' => '300px',
	'id' => 'poll-result-chart-pie',
	'class' => $chart_class,
	'data-chart-type' => 'pie',
	'data-chart-data' => json_encode($results),
]);
echo elgg_format_element('div', ['id' => 'poll-result-chart-pie-wrapper', 'class' => $pie_class], $pie_chart);

$bar_chart = elgg_format_element('canvas', [
	'width' => '600px',
	'height' => '300px',
	'id' => 'poll-result-chart-bar',
	'class' => $chart_class,
	'data-chart-type' => 'bar',
	'data-chart-data' => json_encode($bar_data),
]);
echo elgg_format_element('div', ['id' => 'poll-result-chart-bar-wrapper', 'class' => ['poll-content', 'hidden']], $bar_chart);
