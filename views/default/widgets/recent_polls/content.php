<?php

$widget = elgg_extract('entity', $vars);

$container = $widget->getContainerEntity();

$options = [
	'type' => 'object',
	'subtype' => Poll::SUBTYPE,
	'limit' => (int) $widget->num_display ?: 5,
	'pagination' => false,
];

if (($container instanceof ElggUser) && ($widget->context !== 'dashboard')) {
	$options['owner_guid'] = $container->guid;
	$options['preload_containers'] = true;
} elseif ($container instanceof ElggGroup) {
	$options['container_guid'] = $container->guid;
	$options['preload_owners'] = true;
}

echo elgg_list_entities($options);
