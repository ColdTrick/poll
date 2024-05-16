<?php

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'objectpicker',
	'#label' => elgg_echo('poll:widgets:single_poll:poll_guid:object'),
	'name' => 'params[poll_guid]',
	'values' => $widget->poll_guid,
	'subtype' => \Poll::SUBTYPE,
	'limit' => 1,
]);
