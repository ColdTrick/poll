<?php
/**
 * Summary/listing view of a Poll
 *
 * @uses $vars['entity'] the Poll to view
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \Poll) {
	return;
}

$content = elgg_get_excerpt((string) $entity->description);

if (elgg_extract('show_poll_tabs', $vars, false)) {
	$content .= elgg_view('poll/view/tabs', $vars);
}

$content .= elgg_view('poll/view/close_date', $vars);

// brief view
$params = [
	'content' => $content,
	'icon' => true,
];
$params = $params + $vars;
echo elgg_view('object/elements/summary', $params);
