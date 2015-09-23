<?php

$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 5;
}

$container = $widget->getContainerEntity();

$options = [
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => $num_display,
];

if ($container instanceof ElggUser) {
	$options['owner_guid'] = $container->getGUID();
} elseif ($container instanceof ElggGroup) {
	$options['container_guid'] = $container->getGUID();
}

echo elgg_list_entities($options);