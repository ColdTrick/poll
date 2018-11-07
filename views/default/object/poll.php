<?php
/**
 * View for poll objects
 *
 * @uses $vars['entity'] Poll entity to show
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \Poll) {
	return;
}

if (elgg_extract('full_view', $vars)) {
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
} else {
	$content = elgg_get_excerpt($entity->description);
	
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
}
