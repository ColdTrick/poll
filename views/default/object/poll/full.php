<?php
/**
 * Full view of a Poll
 *
 * @uses $vars['entity'] the Poll to view
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \Poll) {
	return;
}

$body = elgg_view('output/longtext', [
	'value' => $entity->description,
]);

$body .= elgg_view('poll/view/tabs', $vars);
$body .= elgg_view('poll/view/close_date', $vars);

$params = [
	'icon' => true,
	'body' => $body,
	'show_summary' => true,
	'show_navigation' => true,
];
$params = $params + $vars;
echo elgg_view('object/elements/full', $params);
