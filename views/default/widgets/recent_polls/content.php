<?php

$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 5;
}

$container = $widget->getContainerEntity();

$options = [
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'limit' => $num_display,
	'pagination' => false,
];

if (($container instanceof ElggUser) && ($widget->context !== 'dashboard')) {
	$options['owner_guid'] = $container->getGUID();
	$options['preload_containers'] = true;
} elseif ($container instanceof ElggGroup) {
	$options['container_guid'] = $container->getGUID();
	$options['preload_owners'] = true;
}

echo elgg_list_entities($options);
