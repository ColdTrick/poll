<?php

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);

echo elgg_view('object/widget/edit/num_display', [
	'entity' => elgg_extract('entity', $vars),
	'default' => 5,
	'min' => 1,
	'max' => 10,
]);
