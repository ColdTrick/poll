<?php
/**
 * Group poll module
 */

$params = [
	'title' => elgg_echo('poll:group'),
	'entity_type' => 'object',
	'entity_subtype' => \Poll::SUBTYPE,
];
$params = $params + $vars;
echo elgg_view('groups/profile/module', $params);
