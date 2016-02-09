<?php
$entity = elgg_extract('entity', $vars);

// show optional close date
$close_date = (int) $entity->close_date;
if (empty($close_date)) {
	return;
}
$close_translation_key = 'poll:closed';
if ($close_date > time()) {
	$close_translation_key = 'poll:closed:future';
}

$content = elgg_echo($close_translation_key) . ' ' . elgg_view_friendly_time($close_date);

echo elgg_format_element('div', ['class' => 'elgg-subtext'], $content);
