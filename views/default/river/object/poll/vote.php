<?php

$item = elgg_extract('item', $vars);
$entity = $item->getObjectEntity();
if (!$entity instanceof Poll) {
	return;
}

$annotation = $item->getAnnotation();
if ($annotation instanceof ElggAnnotation) {
	$label = $entity->getAnswerLabel($annotation->value);
	$vars['message'] = $label;
}

echo elgg_view('river/elements/layout', $vars);
